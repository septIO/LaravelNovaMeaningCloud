# LaravelNovaMeaningCloud
A field for Laravel Nova that generates summarized text from another text field by using Meaning Cloud's API

This packages requires an account on [Meaninccloud.com](https://www.meaningcloud.com/) (don't worry, it's free)

## Installation
You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
$ composer require septIO/LaravelNovaMeaningCloud
```

In your `.env` file add the following line:
```bash
MEANINGCLOUD_KEY=[Your Meaning Cloud API key]
```

## Usage
Import the field into your Nova resource:
```php
use Septio\LaravelMeaningcloud\LaravelMeaningcloud;
```

Add the field to your `fields[]` array:
```php
public function fields(Request $request)
    {
        return [
            //... Rest of fields
            LaravelMeaningcloud::make("resume")->from("Body")->sentences(5)->hideFromIndex(),
        ];
    }
```

The Field needs 2 inputs:
`make("table column")`, as usual, the `make` refers to the column on the table which this field writes/reads from.

`from("Other Field Name")` is the field which the text summarization should ready from.

`sentences(x)` is optional. If set to a number, then the text from `from()` will be summarized in `x` amount of sentences. Default is 3

## Examples

Let's setup a simple blog
```php
public function fields(Request $request){
    return [
        Text::make("title"),
        Trix::make("body"), // We'll use the builtin Trix editor for the body
        LaravelMeaningCloud::make("resume")->from("Body"),
        BelongsTo::make("author")
    ];
}
```
The `from` needs to match the *placeholder* if the referenced field, **not** the name.
The reason for this is shown in the next example.

Let's change the display name of the body field:
```php
public function fields(Request $request){
    return [
        Text::make("title"),
        Trix::make("Text to display", "body"), // Now "Body" doesn't work anymore
        LaravelMeaningCloud::make("resume")->from("Text to display"), // We'll have to use "Text to display"
        BelongsTo::make("author")
    ];
}
```

## Notice
This tool is reliable on AI from [Meaninccloud.com](https://www.meaningcloud.com/), so results may wary.
