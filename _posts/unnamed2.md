Visual Studio "15" Preview 5 reports which extensions are slowing it down. 
You can load the extension in an asynchronous fashion by converting Package into AsyncPackage. Unfortunately, this type is located in assembly Microsoft.VisualStudio.Shell.14.0, which means that the price for reducing load time is dropping support for Visual Studio 2013.

In short, replace GetService() with GetServiceAsync(). If it's not available, SwitchToMainThreadAsync() and then GetService(). You also need to SwitchToMainThreadAsync() to add menu items and buttons, since they live in the UI thread.


using Tasks = System.Threading.Tasks;
Change Initialize() to protected override async Tasks.Task InitializeAsync(Threading.CancellationToken token, IProgress<ServiceProgressData> progress)

Add first two lines:
            await base.InitializeAsync(token, progress);
            var asyncServiceProvider = (Microsoft.VisualStudio.Shell.IAsyncServiceProvider)this;

Add services using GetServiceAsync

DTE dte = await asyncServiceProvider.GetServiceAsync(typeof(DTE)) as DTE;
var outputWindow = await asyncServiceProvider.GetServiceAsync(typeof(SVsOutputWindow)) as IVsOutputWindow;
            var statusBar = await asyncServiceProvider.GetServiceAsync(typeof(SVsStatusbar)) as IVsStatusbar;
OleMenuCommandService mcs = await asyncServiceProvider.GetServiceAsync(typeof(IMenuCommandService)) as OleMenuCommandService;

Not everything will work async

GetGlobalService can be replaced with await GetServiceAsync, but GetService needs to be synchronous.

            var componentModel = (IComponentModel)AsyncPackage.GetGlobalService(typeof(SComponentModel));
            var workspace = componentModel.GetService<VisualStudioWorkspace>();

into

var componentModel = await asyncServiceProvider.GetServiceAsync(typeof(SComponentModel)) as IComponentModel;
await JoinableTaskFactory.SwitchToMainThreadAsync();
var workspace = componentModel.GetService<VisualStudioWorkspace>();


Add Menu Commands only in UI thread

await JoinableTaskFactory.SwitchToMainThreadAsync();

// PSST… Do I need to create instances in UI thread too?
                CommandID toolwndCommandID = new CommandID(GuidList.guidProjectOrangeCmdSet, (int)PkgCmdIDList.cmdidShowLaunchControl);
                MenuCommand menuToolWin = new MenuCommand(ShowLaunchControlCallback, toolwndCommandID);
// This one for sure:
mcs.AddCommand(menuToolWin);
