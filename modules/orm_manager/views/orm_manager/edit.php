<?php
$columns = (method_exists($model, 'get_edit_columns')) ?
    $model->get_edit_columns() : $model->table_columns;

$column_index = 0;

$model_name = $model->object_name;
$primary_key = $model->primary_key;
$primary_key_value = $row->{$primary_key};

$h = html::escape_array(compact(
    'primary_key', 'primary_key_value', 'model_name', 'return_page'
));
$u = html::urlencode_array(compact(
    'model_name', 'return_page'
));

?>
<div class="edit">

    <ul class="nav">
        <?php
            $return_url = "{$url_base}/model/{$u['model_name']}";
            if (!empty($u['return_page'])) {
                $return_url .= '/page/' . $u['return_page'];
            }
        ?>
        <li><a href="<?=$return_url?>">&laquo; back to list</a></li>
    </ul>

    <form method="POST">
        <input type="hidden" name="primary_key" value="<?=$h['primary_key_value']?>" />
        <input type="hidden" name="return_page" value="<?=$h['return_page']?>" />
        
        <table>
            <tbody>

                <th colspan="2" class="controls">
                    <input type="submit" name="save" value="Save" />
                </th>

                <?php foreach ($columns as $column_name=>$column_info): ?>
                    <?php
                        $column_view = method_exists($model, 'get_edit_column_view') ?
                            $column_view = $model->get_edit_column_view(
                                $view_base, $column_name, $column_info
                            ) :
                            View::factory("{$view_base}/edit/default_column");

                        $column_value = isset($form[$column_name]) ?
                            $form[$column_name] : $row->{$column_name};
                    ?>
                    <?=$column_view->set(array(
                        'model'        => $model,
                        'row'          => $row,
                        'columns'      => $columns,
                        'column_index' => ($column_index++),
                        'column_value' => $column_value,
                        'column_name'  => $column_name,
                        'column_info'  => $column_info,
                    ))->render()?>
                <?php endforeach ?>

                <th colspan="2" class="controls">
                    <input type="submit" name="save" value="Save" />
                </th>

            </tbody>
        </table>

    </form>
</div>
