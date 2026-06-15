# ACF Field Registration

Register advanced custom fields with object oriented PHP using the Extended ACF Plugin.

Visit the [Extended ACF github README](https://github.com/vinkla/extended-acf) for a full list of field examples and documentation.

## **Field Names**

By default, the field name is created by sanitizing the title (all lowercase and spaces replaced with dashes). If you prefer to name it something different, this can be added as a second argument to the `make` method for any field.

## **Examples**

_Note: Use statements must be added for every class (field) used._

**Basic Fields**

```php
Text::make(__('Headline', 'rosecrance'))
  ->instructions(__('Instructions go here.', 'rosecrance'))
  ->required();
```

```php
Textarea::make(__('Content', 'rosecrance'))
  ->instructions(__('Instructions go here.', 'rosecrance'))
  ->rows(2);
```

```php
WysiwygEditor::make(__('Content', 'rosecrance'))
  ->instructions(__('Instructions go here.', 'rosecrance'))
  ->mediaUpload(false)
  ->required();
```

```php
Url::make(__('Url', 'rosecrance'))
  ->instructions(__('Instructions go here.', 'rosecrance'))
  ->required();
```

```php
ColorPicker::make(__('Color', 'rosecrance'))
  ->instructions(__('Instructions go here.', 'rosecrance'))
  ->defaultValue('#4a9cff')
  ->required();
```

```php
Image::make(__('Image', 'rosecrance'))
  ->instructions(__('Instructions go here.', 'rosecrance'))
  ->returnFormat('array')
  ->previewSize('thumbnail') // thumbnail, medium or large
  ->required();
```

```php
Select::make(__('Select', 'rosecrance'))
  ->instructions(__('Instructions go here.', 'rosecrance'))
  ->choices([
    'choice-1' => __('Choice 1', 'rosecrance'),
    'choice-2' => __('Choice 2', 'rosecrance'),
  ])
  ->defaultValue('choice-1')
  ->returnFormat('value') // value, label or array
  ->allowMultiple()
  ->required();
```

```php
TrueFalse::make(__('True or False', 'rosecrance'))
  ->instructions(__('Instructions go here.', 'rosecrance'))
  ->defaultValue(false)
  ->stylisedUi() // optinal on and off text labels
  ->required();
```

**Group**

```php
Group::make(__('Group', 'rosecrance'))
  ->instructions(__('Instructions go here.', 'rosecrance'))
  ->fields([
    Text::make(__('Text', 'rosecrance')),
    Image::make(__('Image', 'rosecrance')),
  ])
  ->layout('row')
  ->required();
```

**Repeater**

```php
Repeater::make(__('Repeater', 'rosecrance'))
  ->instructions(__('Instructions go here.', 'rosecrance'))
  ->fields([
    Text::make(__('Text', 'rosecrance')),
    Image::make(__('Image', 'rosecrance')),
  ])
  ->min(2)
  ->collapsed('name')
  ->buttonLabel(__('Add Component', 'rosecrance'))
  ->layout('table') // block, row or table
  ->required();
```

**Conditional Logic**

```php
Select::make(__('Select', 'rosecrance'))
    ->choices([
        'choice-1' => __('Choice 1', 'rosecrance'),
        'choice-2' => __('Choice 2', 'rosecrance'),
    ]),
Text::make(__('Text', 'rosecrance'))
    ->conditionalLogic([
        ConditionalLogic::where('select', '==', 'choice-1')
    ]);
```
