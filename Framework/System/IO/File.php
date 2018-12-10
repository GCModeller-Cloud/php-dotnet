<?php

/**
 * Provides static methods for the creation, copying, deletion, moving, and opening of a single file, 
 * and aids in the creation of System.IO.FileStream objects.To browse the .NET Framework source code 
 * for this type, see the Reference Source.
 */
class File {

	public static function WriteAllText($path, $contents, $encoding = "Utf8") {
		
	}	
	
	/**
	 * Opens a file, reads all lines of the file with the specified encoding, and then closes the file.
	 * 
	 * @param path      The file to open for reading.
	 * @param encoding  The encoding applied to the contents of the file.
	 *
	 * @returns A string containing all lines of the file.
	 */
	public static function ReadAllText($path, $encoding = "Utf8") {
		return file_get_contents($path);
	}

	/**
	 * @param string $path The file path
	 * @param string $encoding The text file encoding name.
	 * 
	 * @return string[]
	*/
	public static function ReadAllLines($path, $encoding = "Utf8") {
		return StringHelpers::LineTokens(file_get_contents($path));
	}

	public static function Exists($path) {
		return file_exists($path);
	}
}
?>