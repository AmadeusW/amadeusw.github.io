Refactor code automatically with Analyzers
===

So you need to refactor a hundred classes in that old code base? This sounds like a long day manually editing files, one by one. Do you want to spend your day writing a program that will do your job? Read on!

When you write or browse C# code in Visual Studio 2015, the IDE runs dozens of little scripts called Analyzers to warn you of mistakes in the code and offer help refactoring. There are open source communities that write analyzers that help make your code more performant, more reliable and better laid out. They are quick - they act when you type to give you rapid feedback: underline code and appear in the Ctrl+. (lightbulb) menu.

Let's see how we can write an analyzer to help out with a repetive task. We will cut a few corners, because noone will use this code again. It doesn't need to be fast, so it can perform extensive work - once. It's made with one task in mind, and even then, it's okay to miss a few edge cases - you will fix them manually in no time.

~~~

Start a new **Extensibility > Analyzer with Code Fix** project. Project1 contains CodeFixProvider and RefactoringHelper. The first type contains logic that finds places eligible for error/warning/refactoring, and the second contains logic behind the remedy of editing the user's code. The Vsix project registers the Analyzer within Visual Studio. And most importantly, the test project contains a basic framework for validating analyzers.  

<aside>If you don't see it, install VSSDK, or in newest Visual Studio, install the Extensibility tools.</aside>

~~~

Open another Visual Studio. Fetch (or make up) the code that needs to be refactored. Paste it into the "before" string in the unit test. Put refactored code in the "after" string. Fetch some code that shouldn't be refactored. Paste it into both "before" and "after" strings to verify that your analyzers knows its limits!

<aside>Consider adding more test cases throughout the day as you discover more edge cases</aside>

It's a good idea to put working code into the tested strings. Certain analyzers (that use semantic model) only work on code that compiles, and we will extensively use these tests to develop the analyzer. Which analyzer do you need? You can register SyntaxXXXXXX or SemanticXXXXX. Syntax analysis operates on raw text of the script, making it faster to write, debug and execute. Semantic analysis has insight into the meaning of code, once it's built. It can tell apart `Console` in `System.Console` and `MyLibrary.Console`, check if method's `Task` parameter is indeed a `System.Threading.Tasks.Task` or its cousin `Something.Else.Task`. Pick depending on complexity of your problem.

~~~

Let's look at some common patterns and scenarios that we use in CodeFixProvider. Generally, try to precisely describe how to find the code of interest.

Introduction to SyntaxVisualizer

Finding a method with specific name

Finding a method with specific parameter
 Name matched as string
 Type matched as string
 Type matched as Type

Finding a method with specific type of return value
###

Finding a class that implements an interface
###

Complete example: efoqus
###

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