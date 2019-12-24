<?php

imports("System.Diagnostics.StackTrace");
imports("System.Text.StringBuilder");
imports("Microsoft.VisualBasic.ApplicationServices.Debugger.Logging.LogEntry");
imports("Microsoft.VisualBasic.FileIO.FileSystem");

class LogFile {
	
	public $handle;
	
	function __construct($path) {
		FileSystem::CreateDirectory(
		FileSystem::GetParentPath($path));

		$this->handle = $path;

		if (!file_exists($path)) {
			# echo "No log file exist!";
			FileSystem::WriteAllText($path, "=======LogFile for php.NET=======<br /><br />\n\n");
		}
	}
	
	/**
	 * set_error_handler(new LogFile("path/to/file.log")->LoggingHandler, E_ALL);
	 */
	public function LoggingHandler($errno, $errstr, $errfile, $errline) {
		// 创建logentry对象和logbody，然后将数据拓展进入目标日志文件之中
		$entry = new LogEntry($errno, $errfile, $errline);

		$log = new StringBuilder();
		$log ->AppendLine($entry->__toString())
			 ->AppendLine()
			 ->AppendLine("<pre>" . $errstr . "</pre>")
			 ->AppendLine("")
			 ->AppendLine(StackTrace::GetCallStack()->ToString())
			 ->AppendLine("<br />");

		// echo $errno   . "\n";
		// echo $errstr  . "\n";
		// echo $errfile . "\n";
		// echo $errline . "\n";

		// echo $this->handle . "\n";

		# echo $this->handle . "\n";
		# echo $log->ToString() . "\n";

		FileSystem::WriteAllText($this->handle, $log->ToString(), TRUE);
		
		/* Don't execute PHP internal error handler */
		return true;
	}
}

?>