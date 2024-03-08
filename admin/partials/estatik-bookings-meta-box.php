<?php
/**
 * @var int $start_date - Booking start date timestamp
 * @var int $end_date - Booking end date timestamp
 * @var string $address - Booking address
 */
?>

<div>
    <label for="start_date">Start Date:</label>
    <input type="text" id="start_date" name="start_date" value="<?php echo empty($start_date) ? "" : esc_attr(date("Y-m-d", $start_date)); ?>" />
</div>

<br>

<div>
    <label for="end_date">End Date:</label>
    <input type="text" id="end_date" name="end_date" value="<?php echo empty($end_date) ? "" : esc_attr(date("Y-m-d", $end_date)); ?>" />
</div>

<br>

<div>
    <label for="address">Address:</label>
    <input type="text" id="address" name="address" value="<?php echo empty($address) ? "" : esc_attr($address); ?>" />
</div>

<script>
    jQuery(document).ready(function($) {
        $('#start_date, #end_date').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            minDate: "yy-mm-dd"
        });
    });
</script>