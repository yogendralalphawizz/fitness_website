<div class="container"
<div class="accordion-container col-sm-12" style="margin-bottom:50px;">
  <h2>FAQs</h2>
  <?php
  if($faq_details)
  {
      foreach($faq_details as $faq_row)
      {
  ?>
  <div class="set">
    <a href="javascript:void(0);">
      <?=$faq_row['question']?>
      <i class="fa fa-plus"></i>
    </a>
    <div class="content">
      <p> <?=$faq_row['answer']?></p>
    </div>
  </div>
  <?php
      }
  }
  ?>
</div>	
</div>