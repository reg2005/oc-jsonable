Jsonable form widget for October CMS!
======
This widget the alternative to a widget [Repeater](http://octobercms.com/docs/backend/forms#widget-repeater) allows to write data to jsonable field also as well as "Repeater".

![alt text](https://github.com/reg2005/oc-jsonable/blob/master/jsonable-field.jpg)

How to use:
======

##### 0.1 Create a json or jsonb or text field in a database.

##### 0.2 Add in model:
```php
public $jsonable = ['config'];
```


##### 1. Just add into your plugin or project composer.json:

```javascript
{
    "require": {
        "reg2005/oc-jsonable": "1.0.*"
    }
}
```
##### 2. Go to your october project directory use terminal, and run command:

> composer update

##### 3. Add to your Plugin.php this:
```php
    public function registerFormWidgets()
    {
        return [
            'reg2005\Widgets\Jsonable' => [
                'label' => 'jsonable',
                'code'  => 'jsonable'
            ]
        ];
    }
```
ADD to your fields.yaml something like:
```yaml
fields:
    config[customization]:
            label: 'extra'
            type: jsonable
            form:
                fields:
                    form_color:
                        label: 'Color'
                        oc.commentPosition: ''
                        span: left
                        type: colorpicker
                    background:
                        label: 'Background'
                        oc.commentPosition: ''
                        mode: image
                        useCaption: 0
                        thumbOptions:
                            mode: crop
                            extension: jpg
                        span: left
                        type: fileupload
                    time[mon]:
                        label: Monday
                        type: jsonable
                        span: left
                        form:
                            fields:
                                from:
                                    label: 'From'
                                    oc.commentPosition: ''
                                    span: left
                                    default: '09:00'
                                    type: datepicker
                                    format: 'H:i'
                                    mode: time
                                to:
                                    label: 'To'
                                    oc.commentPosition: ''
                                    span: right
                                    default: '18:00'
                                    format: 'H:i'
                                    type: datepicker
                                    mode: time
                    time[tue]:
                        label: Tuesday
                        type: jsonable
                        span: left
                        form:
                            fields:
                                from:
                                    label: 'From'
                                    oc.commentPosition: ''
                                    span: left
                                    default: '09:00'
                                    type: datepicker
                                    mode: time
                                to:
                                    label: 'To'
                                    oc.commentPosition: ''
                                    span: right
                                    default: '18:00'
                                    type: datepicker
                                    mode: time
```
