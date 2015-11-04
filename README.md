#### GeckoPackages

# PHPUnit extensions

Provides additional asserts to be used in PHPUnit test.
The asserts are provided using Traits so no changes are needed in the hierarchy of test classes.

The additional asserts are provided through the Traits:

- **FileExistsTrait**  
  Replaces the PHPUnit `assertFileExists` method. This assert does not pass if there is a directory rather than a file.
- **FileSystemAssertTrait**  
  Provides asserts for testing directories, files and symbolic links.
- **ScalarAssertTrait**  
  Provides asserts for testing of scalars such as integer, float, etc.
- **XMLAssertTrait**  
  Additional PHPUnit asserts for testing XML based logic.

See Traits and asserts listing for more details.

### Requirements

PHP 5.4.0 (for Traits)
PHPUnit PHPUnit >= 3.5.0 (https://phpunit.de/)

# Traits and asserts listing

## FileExistsTrait
###### GeckoPackages\PHPUnit\Asserts\FileExistsTrait
Replacement for PHPUnits `assertFileExists` and `assertFileNotExists`.
Asserts when the filename exists and is a regular file, i.e. directories do not pass.
(Note. Since this changes the default behaviour of the PHPUnit assert this has been placed in a separate trait)
Requires PHPUnit >= 3.0.0 (https://phpunit.de/).

### Methods

#### assertFileExists()
###### assertFileExists(string $filename [,string $message = ''])
Assert the filename exists and is a regular file.

The inverse assertion
#### assertFileNotExists()
###### assertFileNotExists(string $filename [,string $message = ''])
Assert the filename does not exists or is not a regular file.


## FileSystemAssertTrait
###### GeckoPackages\PHPUnit\Asserts\FileSystemAssertTrait
Additional PHPUnit asserts for testing file (system) based logic.
Requires PHPUnit >= 3.0.0 (https://phpunit.de/).

### Methods

#### assertDirectoryEmpty()
###### assertDirectoryEmpty(string $filename [,string $message = ''])
Assert that a directory exists and is empty.

The inverse assertion
#### assertDirectoryNotEmpty()
###### assertDirectoryNotEmpty(string $filename [,string $message = ''])
Assert that a directory exists and is not empty.


#### assertDirectoryExists()
###### assertDirectoryExists(string $filename [,string $message = ''])
Assert that a directory exists.

The inverse assertion
#### assertDirectoryNotExists()
###### assertDirectoryNotExists(string $filename [,string $message = ''])
Assert that a filename does not exists as directory.


#### assertFileHasPermissions()
###### assertFileHasPermissions(int|string $permissions, string $filename [,string $message = ''])
Asserts that a file permission matches, for example: 'drwxrwxrwx' or '0664'.

#### assertFileIsLink()
###### assertFileIsLink(string $filename [,string $message = ''])
Assert that a file is a symbolic link.

The inverse assertion
#### assertFileIsNotLink()
###### assertFileIsNotLink(string $filename [,string $message = ''])
Assert that a file is not a symbolic link.


#### assertFilePermissionMask()
###### assertFilePermissionMask(int $permissionMask, string $filename [,string $message = ''])
Asserts that a file permission matches mask, for example: '0007'.

The inverse assertion
#### assertFilePermissionNotMask()
###### assertFilePermissionNotMask(int $permissionMask, string $filename [,string $message = ''])
Asserts that a file permission does not matches mask, for example: '0607'.


## ScalarAssertTrait
###### GeckoPackages\PHPUnit\Asserts\ScalarAssertTrait
Additional shorthand PHPUnit asserts to test (for) scalar types.
Requires PHPUnit >= 3.5.0 (https://phpunit.de/).

### Methods

#### assertArray()
###### assertArray(mixed $actual [,string $message = ''])
Assert value is an array.

The inverse assertion
#### assertNotArray()
###### assertNotArray(mixed $actual [,string $message = ''])
Assert value is not an array.


#### assertBool()
###### assertBool(mixed $actual [,string $message = ''])
Assert value is a bool (boolean).

The inverse assertion
#### assertNotBool()
###### assertNotBool(mixed $actual [,string $message = ''])
Assert value is not a bool (boolean).


#### assertFloat()
###### assertFloat(mixed $actual [,string $message = ''])
Assert value is a float (double, real).

The inverse assertion
#### assertNotFloat()
###### assertNotFloat(mixed $actual [,string $message = ''])
Assert value is not a float (double, real).


#### assertInt()
###### assertInt(mixed $actual [,string $message = ''])
Assert value is an int (integer).

The inverse assertion
#### assertNotInt()
###### assertNotInt(mixed $actual [,string $message = ''])
Assert value is not an int (integer).


#### assertScalar()
###### assertScalar(mixed $actual [,string $message = ''])
Assert value is a scalar.

The inverse assertion
#### assertNotScalar()
###### assertNotScalar(mixed $actual [,string $message = ''])
Assert value is not a scalar.


#### assertString()
###### assertString(mixed $actual [,string $message = ''])
Assert value is a string.

The inverse assertion
#### assertNotString()
###### assertNotString(mixed $actual [,string $message = ''])
Assert value is not a string.


#### assertStringIsEmpty()
###### assertStringIsEmpty(mixed $actual [,string $message = ''])
Assert value is a string and is empty.

The inverse assertion
#### assertStringIsNotEmpty()
###### assertStringIsNotEmpty(mixed $actual [,string $message = ''])
Assert value is a string and is not empty.


#### assertStringIsWhiteSpace()
###### assertStringIsWhiteSpace(mixed $actual [,string $message = ''])
Assert value is a string and only contains white space characters (" \t\n\r\0\x0B").

The inverse assertion
#### assertStringIsNotWhiteSpace()
###### assertStringIsNotWhiteSpace(mixed $actual [,string $message = ''])
Assert value is a string and not only contains white space characters (" \t\n\r\0\x0B").


## XMLAssertTrait
###### GeckoPackages\PHPUnit\Asserts\XMLAssertTrait

Requires:
* PHPUnit >= 3.0.0 (https://phpunit.de/)
* libxml (https://secure.php.net/manual/en/book.libxml.php)

### Methods

#### assertXMLMatchesXSD()
###### assertXMLMatchesXSD(string $XML, string $XSD [,string $message = ''])
Assert string is XML formatted as defined by the XML Schema Definition.

#### assertXMLValid()
###### assertXMLValid(string $XML [,string $message = ''])
Assert string is valid XML.

### License

The project is released under the MIT license, see the LICENSE file.
