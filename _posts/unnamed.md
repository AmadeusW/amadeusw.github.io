Refactor code automatically with Analyzers
===

So you need to refactor a hundred classes in that old code base? This sounds like a long day manually editing files, one by one. Do you want to spend your day writing a program that will do your job? Read on!

When you write or browse C# code in Visual Studio 2015, the IDE runs dozens of little scripts called Analyzers to warn you of mistakes in the code and offer help refactoring. There are open source communities that write analyzers that help make your code more performant, more reliable and better laid out. They are quick - they act when you type to give you rapid feedback: underline code and appear in the Ctrl+. (lightbulb) menu.

Let's see how we can write an analyzer to help out with a repetive task. We will cut a few corners, because noone will use this code again. It doesn't need to be fast, so it can perform extensive work - once. It's made with one task in mind, and even then, it's okay to miss a few edge cases - you will fix them manually in no time.

~~~

Start a new **Extensibility > Analyzer with Code Fix** project. The main project contains DiagnosticAnalyzer and CodeFixProvider. The first type contains logic that finds places eligible for error/warning/refactoring, and the second contains logic that edits user's code. The **.Vsix** project registers the Analyzer within Visual Studio. And most importantly, the **.Test** project contains a basic framework for validating analyzers.  

<aside>If you don't see it, install VSSDK, or in newest Visual Studio, install the Extensibility tools.</aside>

~~~

Open another Visual Studio. Fetch (or make up) the code that needs to be refactored - usually a method within a class is fine. Paste it into the `var test = ` string in the unit test. Put refactored code in the `var fixtest = ` string. These are the "before" and "after" variables for the tests. To verify that your analyzer knows it limits, provide some code that shouldn't be refactored into the XXX test case.

<aside>Consider adding more test cases throughout the day as you discover more edge cases</aside>

Certain analyzers (that use semantic model) only work on code that compiles, so provide your code in a class within a namespace with all applicable usings. Example. Do you need code that compiles? This depends if you analyze semantics of the code, or just the syntax. Syntax analysis operates on raw text of the script, making it faster to write, debug and execute. Semantic analysis has insight into the meaning of code, once it's built. It can tell apart `Console` in `System.Console` and `MyLibrary.Console`, check if method's `Task` parameter is indeed a `System.Threading.Tasks.Task` or its cousin `Something.Else.Task`. Pick depending on complexity of your problem.

~~~

Let's look at some common patterns and scenarios that we use in DiagnosticAnalyzer. Generally, try to precisely describe how to find the code of interest.

Introduction to DiagnosticAnalyzer
##

The `DiagnosticAnalyzer` class defines a lot of properites for proper presentation within Visual Studio. Then it registers the analyzer in the `Initialize` method. This is where you choose if it's a syntax or semantic analyzer. Register the former with `context.RegisterSyntaxNodeAction` and the latter with `contextRegisterXXX`. First parameter is the function with your analyzer's logic, and the second parameter tells the compiler what bit of syntax we're looking at. This initially narrows down your search space, but it also optimizes performance of Visual Studio, indicating specific pieces of syntax are to by analyzed.

Introduction to Syntax Visualizer
##

Open Syntax Visualizer with `View > Other Windows > Syntax Visualizer`. Notice that the Syntax Visualizer updates based on the caret position, so go ahead and place the caret at code that interests you. In the next example we will take a look at method's name, so go ahead and place the caret in the method's signature and see how the compiler (specifically, lexer) sees it. Read Josh's blog post if you'd like to know more about syntax and its representation in the compiler.

In the screenshot below we see the anatomy of a method. For the purpose of writing an analyzer, nodes with blue labels are also properties of their parents, and these with green labels can be queried using parent's methods. For example:

<div class="fiftyfifty">
<div class="fifty">
![MethodDeclarationSyntax](/blogData/2016-12-12-analzyers/method-anatomy.png)
</div>
<div class="fifty">

```csharp
MethodDeclarationSyntax m;
string name = m.IdentifierName.ToString();
SyntaxNode body = m.Block;
bool async = m.IsAsync();
```

</div>
</div> 

Finding a method with specific name
#


Finding a method with specific parameter
#
 Name matched as string
 Type matched as string
 Type matched as Type

This can be extended to finding a method with specific type of return value


Finding a class that implements an interface
###

Find usages of `new` keyword
###

Complete example: Find usages of `new` keyword followed by usage as a param. 

I needed to fix [stringly typed](https://blog.codinghorror.com/new-programming-jargon/) code in hundreds of documents. The code in question followed a certain pattern, and thus yielded itself to automatic refactoring with an analyzer. In this blog post we will see the CodeFixProvider that finds the pattern in the code, and in the second part we will look at the refactoring that uses `nameof` operator to replace stringly typed code, like so:

```csharp:example.cs

        void Before()
        {
            var filters = new FilterCollection();
            filters.Add("Id", objectId);
            filters.Add("Type", objectType);
            var records = Database.GetRecords<MyTable>(filter);
        }
    
        void After()
        {
            var filters = new FilterCollection();
            filters.Add(nameof(MyTable.Id), objectId);
            filters.Add(nameof(MyTable.Type), objectType);
            var records = Database.GetRecords<MyTable>(filter);
        }
```

The algorithm, in words: Find all usages of `FilterCollection.Add` where the first parameter is a literal string. Find method `Database.GetRecords<T>` where this `FilterCollection` is the first parameter. Fetch the type parameter. Issue a warning over the literal string parameter.