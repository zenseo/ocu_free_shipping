<?php echo $header; ?>
<style>
    table.form td {vertical-align:top}
    #tab-rate td {padding:5px!important}
</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/total.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">

      <div id="tabs" class="htabs">
        <a href="#tab-general" class="selected"><?php echo $tab_shipping_general ?></a>
        <a href="#tab-rate" class="selected"><?php echo $tab_shipping_rate ?></a>
      </div>

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

      <div id="tab-general">
        <table class="form">
          <tr>
            <td><?php echo $entry_estimator; ?></td>
            <td><select name="ocufreeshipping_estimator">
                <?php if ($ocufreeshipping_estimator) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="ocufreeshipping_status">
                <?php if ($ocufreeshipping_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="ocufreeshipping_sort_order" value="<?php echo $ocufreeshipping_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </div>


      <div id="tab-rate">
          <table id="rate-list" class="list">
              <thead>
              <tr>
                  <td><?php echo $text_min_product_qty ?></td>
                  <td><?php echo $text_min_order_cost ?></td>
                  <td><?php echo $text_geo_zone ?></td>
                  <td>&nbsp;</td>
              </tr>
              </thead>
              <?php $rate_row = 0; ?>

              <?php if (count($shipping_rate)) { ?>
                  <?php foreach ($shipping_rate as $value_shipping_rate) { ?>
                      <tbody id="rate-row-<?php echo $rate_row ?>">
                          <tr>

                              <td>
                                  <input type="text" size="4" value="<?php echo $value_shipping_rate['min_product_qty'] ?>" name="ocufreeshipping_rate[<?php echo $rate_row ?>][min_product_qty]" />
                              </td>
                              <td>
                                  <input type="text" size="4" value="<?php echo $value_shipping_rate['min_order_cost'] ?>" name="ocufreeshipping_rate[<?php echo $rate_row ?>][min_order_cost]" />
                              </td>
                              <td>
                                  <select name="ocufreeshipping_rate[<?php echo $rate_row ?>][geo_zone_id]">
                                      <?php foreach ($geo_zones as $geo_zone) { ?>
                                      <option value="<?php echo $geo_zone['geo_zone_id'] ?>" <?php echo ($value_shipping_rate['geo_zone_id'] == $geo_zone['geo_zone_id'] ? 'selected="selected"' : false) ?>><?php echo $geo_zone['name'] ?></option>
                                      <?php } ?>
                                  </select>
                              </td>

                              <td>
                                  <a onclick="$('#rate-row-<?php echo $rate_row; ?>').remove();" class="button"><?php echo $button_shipping_remove; ?></a>
                              </td>
                          </tr>
                      </tbody>
                      <?php $rate_row++ ?>
                  <?php } ?>
              <?php } ?>
              <tfoot>
              <tr>
                  <td colspan="3" id="rate-status"><p style="text-align:center"><?php echo ($rate_row == 0 ? $text_shipping_text_rate_not_found : '&nbsp;') ?></p></td>
                  <td>
                      <a onclick="addRate();" class="button"><?php echo $button_shipping_add_rate ?></a>
                  </td>
              </tr>
              </tfoot>
          </table>
      </div>

      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
    <!--
    $('#tabs a').tabs();


    var module_row = <?php echo $rate_row ?>;

    function addRate() {

        html  = '<tbody id="rate-row-' + module_row + '">';
        html += '  <tr>';
        html += '    <td>';
        html += '      <input type="text" size="4" value="0" name="ocufreeshipping_rate[' + module_row + '][min_product_qty]" />';
        html += '    </td>';
        html += '    <td>';
        html += '      <input type="text" size="4" value="0" name="ocufreeshipping_rate[' + module_row + '][min_order_cost]" />';
        html += '    </td>';
        html += '    <td>';
        html += '      <select name="ocufreeshipping_rate[' + module_row + '][geo_zone_id]">';
        html += '        <?php foreach ($geo_zones as $geo_zone) { ?>';
        html += '          <option value="<?php echo $geo_zone['geo_zone_id'] ?>"><?php echo $geo_zone['name'] ?></option>';
        html += '        <?php } ?>';
        html += '      </select>';
        html += '    </td>';
        html += '    <td>';
        html += '      <a onclick="$(\'#rate-row-' + module_row + '\').remove();" class="button"><?php echo $button_shipping_remove; ?></a>';
        html += '    </td>';
        html += '  </tr>';
        html += '</tbody>';

        $('#rate-status').html(false);
        $('#rate-list tfoot').before(html);
        module_row++;
    }

    //-->
</script>

<?php echo $footer; ?>