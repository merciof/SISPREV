<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });
?>
<nav class="col-md-2 columns" id="actions-sidebar">
    <ul class="nav nav-pills nav-stacked">
        <li class="active"><a><CakePHPBakeOpenTag= __('Actions') CakePHPBakeCloseTag></a></li>
<?php if (strpos($action, 'add') === false): ?>
        <li><CakePHPBakeOpenTag= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $<?= $singularVar ?>-><?= $primaryKey[0] ?>],
                ['confirm' => __('Are you sure you want to delete # {0}?', $<?= $singularVar ?>-><?= $primaryKey[0] ?>)]
            )
        CakePHPBakeCloseTag></li>
<?php endif; ?>
        <li><CakePHPBakeOpenTag= $this->Html->link(__('List {0}', '<?= $pluralHumanName ?>'), ['action' => 'index']) CakePHPBakeCloseTag></li>
<?php
        $done = [];
        foreach ($associations as $type => $data) {
            foreach ($data as $alias => $details) {
                if ($details['controller'] !== $this->name && !in_array($details['controller'], $done)) {
?>
        <li><CakePHPBakeOpenTag= $this->Html->link(__('List {0}', '<?= $this->_pluralHumanName($alias) ?>'), ['controller' => '<?= $details['controller'] ?>', 'action' => 'index']) ?></li>
        <li><CakePHPBakeOpenTag= $this->Html->link(__('New {0}', '<?= $this->_singularHumanName($alias) ?>'), ['controller' => '<?= $details['controller'] ?>', 'action' => 'add']) ?></li>
<?php
                    $done[] = $details['controller'];
                }
            }
        }
?>
    </ul>
</nav>
<div class="<?= $pluralVar ?> form col-md-10 columns content">
    <CakePHPBakeOpenTag= $this->Form->create($<?= $singularVar ?>) CakePHPBakeCloseTag>
    <fieldset>
        <legend>
            <CakePHPBakeOpenTag= $this->Html->tag('i', '', array('class' => 'far fa-edit')) CakePHPBakeCloseTag>
            <CakePHPBakeOpenTag= __('<?= Inflector::humanize($action) ?> {0}', '<?= $singularHumanName ?>') CakePHPBakeCloseTag>
        </legend>
        <CakePHPBakeOpenTagphp
<?php
        $first_input = True;
        foreach ($fields as $field) {
            if (in_array($field, $primaryKey)) {
                continue;
            }
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
                    if ($first_input) {
?>
            echo $this->Form->input('<?= $field ?>', ['options' => $<?= $keyFields[$field] ?>, 'empty' => true, 'autofocus' => 'autofocus']);
<?php
                    } else {
?>
            echo $this->Form->input('<?= $field ?>', ['options' => $<?= $keyFields[$field] ?>, 'empty' => true]);
<?php                      
                    }
                } else {
                    if ($first_input) {
?>
            echo $this->Form->input('<?= $field ?>', ['options' => $<?= $keyFields[$field] ?>, 'autofocus' => 'autofocus']);
<?php
                    } else {
?>
            echo $this->Form->input('<?= $field ?>', ['options' => $<?= $keyFields[$field] ?>]);
<?php                      
                    }
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {
                $fieldData = $schema->column($field);
                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
                    if ($first_input) {
?>
            echo $this->Form->input('<?= $field ?>', ['type' => 'text', 'empty' => true, 'default' => '', 'autofocus' => 'autofocus', 'class' => 'datepicker-start']);
<?php
                    } else {
?>
            echo $this->Form->input('<?= $field ?>', ['type' => 'text', 'empty' => true, 'default' => '', 'class' => 'datepicker-start']);
<?php
                    }
                } else {
                    if ($first_input) {
?>
            echo $this->Form->input('<?= $field ?>', ['autofocus' => 'autofocus']);
<?php
                    } else {
?>
            echo $this->Form->input('<?= $field ?>');
<?php
                     }
                }
            }
            $first_input = False;
        }
        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
?>
            echo $this->Form->input('<?= $assocData['property'] ?>._ids', ['options' => $<?= $assocData['variable'] ?>]);
<?php
            }
        }
?>
        CakePHPBakeCloseTag>
    </fieldset>
    <CakePHPBakeOpenTag= $this->Form->button(__('Submit')) CakePHPBakeCloseTag>
    <CakePHPBakeOpenTag= $this->Form->end() CakePHPBakeCloseTag>
</div>
