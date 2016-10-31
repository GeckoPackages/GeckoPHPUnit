UPGRADE GUIDE FROM 1.x to 2.0
=============================

This is guide for upgrade from version 1.x to 2.0 for the project.

Traits (asserts)
--------------

The `FileExistsTrait` has been renamed to `FileExistsAssertTrait`.

The `StringsAssertTrait` has been added.

The following methods have been moved from `ScalarAssertTrait` to `StringsAssertTrait`:
- `assertStringIsEmpty`
- `assertStringIsNotEmpty`
- `assertStringIsNotWhiteSpace`
- `assertStringIsWhiteSpace`

New methods have been added to `StringsAssertTrait`:
- `assertNotSameStrings`
- `assertSameStrings`

Constraints
--------------

The constraints have been made atomic and are now part of the API supporting 5.3.6 and up.

Therefor the constructors of the following constraints have been changed:
- `FilePermissionsIsIdenticalConstraint`
- `FilePermissionsMaskConstraint`

The XML constraints have been changed:
- `AbstractXMLConstraint`
- `XMLValidConstraint`
- `XMLMatchesXSDConstraint`
