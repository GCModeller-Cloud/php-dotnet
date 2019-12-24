<?php

# include NULL;
include "../package.php";

dotnet::AutoLoad("", TRUE);

global $APP_DEBUG;

echo "A:" . true == $APP_DEBUG  .   "  \n\n\n";

# dotnet::AutoLoad("", FALSE);

echo "B:" . true == $APP_DEBUG  .   "  \n\n\n";

imports("System.Threading.Thread");
imports("php.Utils");
imports("Debugger.engine");

use System\Threading\Thread as Thread;

# echo var_dump(dotnetDebugger::GetLoadedFiles());

# echo var_dump(dotnet::$debugger->script_loading);

function sleepTest() {

    echo Utils::Now(FALSE) . "\n\n";

    # 0.5s
    Thread::Sleep(500);

    echo Utils::Now(FALSE) . "\n\n";;

    # 3.5s
    Thread::Sleep(3500);

    echo Utils::Now(FALSE) . "\n\n";;

}

sleepTest();

?>