# Zelasli Debugger

Zelasli Debugger module for handling errors and exception and display the errors when the debug mode is on otherwise it display an eror message.

## Demo

Include the required classes and initialize the debugger.

```php
include 'path/to/file/Engine.php'
include 'path/to/file/Handler.php'
include 'path/to/file/RenderExceptionInterface.php'

// First parameter is the debug mode type
// Second parameter is the debug environment type (production or development)
$debugger = new Engine(true, 'development');

// To start the debugger and handler.
$debugger->initialize();
```

You can also customize the default handler rendering view by using the **RenderExceptionInterface**

```php
class PageNotFoundException extends Exception implements RenderExceptionInterface
{
    public function render()
    {
        // TODO: implement PageNotFoundException view
        $view = "<h1>Page not Found (404)<h1>";

        return $view;
    }
}
```
