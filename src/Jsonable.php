<?php namespace Reg2005\Widgets;

use Backend\Classes\FormField;
use Backend\Classes\FormWidgetBase;

/**
 * Repeater Form Widget
 */
class Jsonable extends FormWidgetBase
{
    const INDEX_PREFIX = '___index_';

    //
    // Configurable properties
    //

    /**
     * @var array Form field configuration
     */
    public $form;

    /**
     * @var string Prompt text for adding new items.
     */
    public $prompt = 'Add new item';

    /**
     * @var bool Items can be sorted.
     */
    public $sortable = false;

    //
    // Object properties
    //

    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'jsonable';

    /**
     * @var int Count of repeated items.
     */
    protected $indexCount = 0;

    /**
     * @var array Collection of form widgets.
     */
    protected $formWidgets = [];

     /**
      * @var bool Stops nested repeaters populating from previous sibling.
      */
    protected static $onAddItemCalled = true;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->fillFromConfig([
            'form',
            'prompt',
            'sortable',
        ]);

        if (!self::$onAddItemCalled) {
            $this->processExistingItems();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('repeater');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['indexName'] = self::INDEX_PREFIX.$this->formField->getName(false);
        $this->vars['prompt'] = $this->prompt;
        $this->vars['formWidgets'] = $this->formWidgets;
        $this->vars['widget'] = $this->makeItemFormWidget($this->indexCount);
        $this->vars['indexValue'] = $this->indexCount;
        $this->vars['rendered_fields'] = $this->makePartial('repeater_item');

    }

    /**
     * {@inheritDoc}
     */
    public function getSaveValue($value)
    {
        return (array) $value;
    }

    protected function processExistingItems()
    {
        $loadValue = $this->getLoadValue();
        if (is_array($loadValue)) {
            $loadValue = array_keys($loadValue);
        }

        $itemIndexes = post(self::INDEX_PREFIX.$this->formField->getName(false), $loadValue);

        if (!is_array($itemIndexes)) return;

        foreach ($itemIndexes as $itemIndex) {
            $this->makeItemFormWidget($itemIndex);
            $this->indexCount = max((int) $itemIndex, $this->indexCount);
        }
    }

    protected function makeItemFormWidget($index = 0)
    {
        $loadValue = $this->getLoadValue();
        if (!is_array($loadValue)) $loadValue = [];



        $config = $this->makeConfig($this->form);

        $config->model = $this->model;
        $config->data = array_get($loadValue, null, []);

        $config->alias = $this->alias . 'Form'.$index;
        $config->arrayName = $this->formField->getName();

        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        $widget->bindToController();

        return $this->formWidgets[$index] = $widget;
    }

}
