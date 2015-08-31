---
layout: post
title: Using Fiddler to debug Azure exceptions 
category: debugging
permalink: debugging/debugging-azure-with-fiddler
tags: [dotnet, azure, debugging]
---

Today I was fixing `Unexpected response code for operation : 12` exception thrown from `ExecuteBatch` method of `Microsoft.WindowsAzure.Storage.Table.CloudTable`. The exception doesn't have much useful information to aid debugging.  Both `InnerException` and `Data` properties are empty. 

![exception screenshot](/blogData/debugging-azure-with-fiddler/exception.png)

Quick search shows that this exception could mean pretty much anything, but common error scenarios follow a pattern. 

- [Unexpected response code for operation : 99](https://stackoverflow.com/questions/18170920/azure-table-storage-error-unexpected-response-code-for-operation-99) - because the batch operation is limited to 100 elements.
- [Unexpected response code for operation : 1](https://stackoverflow.com/questions/19976862/unexpected-response-code-from-cloudtable-executebatch) - the second `ITableEntity` has a different `PartitionKey` or the same `RowKey` than the first one

*Unexpected response code for operation* errors indicate a zero-based index of the element whose processing triggered an exception. Why would the thirteenth element trigger an exception in my app? Following [Guarav's suggestion in the comment](http://stackoverflow.com/a/20876503/879243) I ran [Fiddler](http://www.telerik.com/fiddler) and found that Azure's exceptions actually carry useful debugging information!

Run Fiddler. In the left side pane, find the entry associated with your app's communication with Azure. In my case, the hostname was `<tablename>.table.core.windows.net`, the URL was `$/batch` and the process was `iisexpress`.
Then, in the bottom-right pane click `TextView` to see the server's response
![fiddler screenshot](/blogData/debugging-azure-with-fiddler/fiddler.png)

The text view contained more detailed error information:

```
{"odata.error":{"code":"PropertyValueTooLarge","message":{"lang":"en-US","value":"12:The property value exceeds the maximum allowed size (64KB). If the property value is a string, it is UTF-16 encoded and the maximum number of characters should be 32K or less.\nRequestId:c0679755-0002-000c-141a-e4596c000000\nTime:2015-08-31T18:28:47.4559166Z"}}}
```

It looks like I tried to send too big of a payload. `TextView` in the top-right pane shows exactly my request, where the thirteenth element was indeed too long. For now, I'll trim the string since the information isn't all that useful, 

```csharp
public const int AZURE_STRING_MAX_LENGTH = 32000;
. . .
if (sourceData.Length > AZURE_STRING_MAX_LENGTH)
{
    myTableEntity.Data = sourceData.Substring(0, AZURE_STRING_MAX_LENGTH);
}
```

# Another approach
A much simpler approach is apparent when you catch the specific exception type. This is a `StorageException` and its `RequestInformation` property contains more information.

```csharp
catch (StorageException ex)
{
    var innerException = ex.RequestInformation.Exception;
```

I wonder why this information isn't readily available when consuming the `Exception` object? Is it to prevent [leaking of sensitive data [gets very off topic]](https://github.com/dotnet/corefx/issues/1187)?


