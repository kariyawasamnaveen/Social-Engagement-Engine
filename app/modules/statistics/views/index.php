<?php
$sections = [
  [
    'id' => 'header_area',
    'url' => cn($controller_name . '/load_header_area'),
  ],
  [
    'id' => 'chart_and_orders_area',
    'url' => cn($controller_name . '/load_chart_and_orders_area'),
    'callback' => 'chartCallback',
  ],
  [
    'id' => 'items_top_best_seller',
    'url' => cn($controller_name . '/load_items_top_best_seller'),
  ],
];
?>


<div class="row justify-content-center row-card statistics" id="statistics-area">
  <?php foreach ($sections as $section): ?>
    <div class="col-sm-12" id="<?= $section['id']; ?>">
      <?= render_component_loader(); ?>
    </div>
  <?php endforeach; ?>
</div>



<script>
  const sectionCallbacks = {
    chartCallback: function(response) {
      Chart_template.chart_spline('#orders_chart_spline', JSON.parse(response.chart_spline));
      Chart_template.chart_pie('#orders_chart_pie', JSON.parse(response.chart_pie));
    }
  };

  const sections = <?= json_encode($sections); ?>;

  $(document).ready(function() {
    sections.forEach(section => {
      const cb = section.callback ? sectionCallbacks[section.callback] : null;
      loadSection(section.url, '#' + section.id, cb);
    });
  });

</script>
