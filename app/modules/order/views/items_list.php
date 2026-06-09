<?php if (!empty($items)) : $i = $from; ?>
    <?php
        foreach ($items as $key => $item) :
            $i++;
            $params['search']['field'] = 'id';
            $item_id = show_high_light(esc($item['id']), $params['search'], 'id');    
            $item_service_name = $item['service_id'] ." - ". $item['service_name'];
            $item_details       = show_item_order_details($controller_name, $item, $params, 'user');
            $item_status = (in_array($item['status'], [ORDER_STATUS_FAIL, ORDER_STATUS_ERROR, ORDER_STATUS_AWAITING])) ? 'pending' : $item['status'];
    ?>
        <tr class="tr_<?php echo esc($item['ids']); ?>">
            <td data-label="Order ID" class="text-center w-10p font-weight-bold"><?=$item_id; ?></td>
            <td data-label="Details">
                <div class="title" style="font-weight: 500;"><?php echo $item_details; ?></div>
            </td>
            <td data-label="Created" class="text-center w-10p"><?=convert_timezone($item['created'], "user")?></td>
            <td data-label="Status" class="text-center w-10p"><?php echo show_item_status($controller_name, $item['id'], $item_status, '', 'user');?></td>
            <td data-label="Actions" class="text-center w-10p">
                <?php
                    if (is_table_exists(ORDERS_REFILL)) {
                        echo show_item_refill_button($controller_name, $item);
                    }
                    if (is_table_exists(ORDERS_CANCEL)) {
                        echo show_item_cancel_button($controller_name, $item);
                    }
                ?>    
            </td>
        </tr>
    <?php endforeach; ?>
<?php else : ?>
    <?php echo render_tr_no_item(); ?>
<?php endif; ?>