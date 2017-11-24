  
<div class="col-lg-4 col-sm-6 col-xs-12">
          <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?php echo number_format($users); ?></h3>

        <p>Registered Users</p>
      </div>
      <div class="icon">
        <i class="fa fa-users"></i>
      </div>
      <a href="<?php echo base_url(); ?>admin/users" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>



  
<div class="col-lg-4 col-sm-6 col-xs-12">
          <!-- small box -->
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo number_format($sites); ?> (<?php echo number_format($completed); ?>)</h3>

        <p>Domains</p>
      </div>
      <div class="icon">
        <i class="fa fa-globe"></i>
      </div>
      <a href="<?php echo base_url(); ?>admin/sites" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>



<div class="col-lg-4 col-sm-6 col-xs-12">
          <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3><?php echo number_format($bookmarks); ?></h3>

        <p>Bookmarks</p>
      </div>
      <div class="icon">
        <i class="fa fa-bookmark"></i>
      </div>
      <a href="#" class="small-box-footer">&nbsp;</a>
    </div>
  </div>




<div class="col-lg-4 col-sm-6 col-xs-12">
          <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>$<?php echo number_format($earnt->total,2); ?></h3>

        <p>Earnings Today</p>
      </div>
      <div class="icon">
        <i class="fa fa-usd"></i>
      </div>
      <a href="<?php echo base_url(); ?>admin/subscriptions/logs" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>


<div class="col-lg-4 col-sm-6 col-xs-12">
          <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>$<?php echo number_format($earnm->total,2); ?></h3>

        <p>Earnings This Month</p>
      </div>
      <div class="icon">
        <i class="fa fa-usd"></i>
      </div>
      <a href="<?php echo base_url(); ?>admin/subscriptions/logs" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

<div class="col-lg-4 col-sm-6 col-xs-12">
          <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>$<?php echo number_format($earny->total,2); ?></h3>

        <p>Earnings This Year</p>
      </div>
      <div class="icon">
        <i class="fa fa-usd"></i>
      </div>
      <a href="<?php echo base_url(); ?>admin/subscriptions/logs" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

<div class="clearfix"></div>
<div class="col-lg-12">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Users Registered Last 12 Months</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
     
      <div class="box-body">
       <div class="col-lg-4">
      <table class="table table-bordered table-hover table-striped">
              <tr>
                <th>Month</th>
                <th>Users</th>
              </tr>
              <?php
                foreach ($registered->result() as $row) 
                {
              ?>
              <tr>
                <td><?php echo $row->month; ?></td>
                <td style="width:20px"><span class="badge bg-red"><?php echo number_format($row->n); ?></span></td>
              </tr>
              <?php
            
            }
            ?>
            </table>
             </div>
              <div class="col-lg-8">
  

          <div id="bar-chart" style="height: 300px;"></div>
        </div>
        
      </div><!-- /.box-body -->
     
     


  </div>
</div>


<?php if($technologies->num_rows() > 0) { ?>
<div class="col-lg-6">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Top Technologies</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
  
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped">
              
              <?php
                foreach ($technologies->result() as $row) 
                {
              ?>
              <tr>
                <td width="50px"><img style="height:30px;" src="<?php echo base_url(); ?>assets/images/icons/<?php echo $row->icon; ?>"></td>
                <td>
                  <strong><?php echo ($row->name); ?></strong>
                  <div class="text-muted"><?php echo ($row->tag1); ?></div>
                  </td>
              </tr>
              <?php
            
            }
            ?>
            </table>
      </div><!-- /.box-body -->
  





  </div>
</div>
<?php } ?>

<div class="row">
<?php if($technologiesw->num_rows() > 0) { ?>
<div class="col-md-6">
  <div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title">Top Web Servers</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
  
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped">
              
              <?php
                foreach ($technologiesw->result() as $row) 
                {
              ?>
              <tr>
                <td width="50px"><img style="height:30px;" src="<?php echo base_url(); ?>assets/images/icons/<?php echo $row->icon; ?>"></td>
                <td>
                  <strong><?php echo ($row->name); ?></strong>
                  <div class="text-muted"><?php echo ($row->tag1); ?></div>
                  </td>
              </tr>
              <?php
            
            }
            ?>
            </table>
      </div><!-- /.box-body -->
  </div>
</div>

<?php } ?>
<?php if($technologiespl->num_rows() > 0) { ?>
<div class="col-md-6">
  <div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title">Top Programming Languages</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
  
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped">
              
              <?php
                foreach ($technologiespl->result() as $row) 
                {
              ?>
              <tr>
                <td width="50px"><img style="height:30px;" src="<?php echo base_url(); ?>assets/images/icons/<?php echo $row->icon; ?>"></td>
                <td>
                  <strong><?php echo ($row->name); ?></strong>
                  <div class="text-muted"><?php echo ($row->tag1); ?></div>
                  </td>
              </tr>
              <?php
            
            }
            ?>
            </table>
      </div><!-- /.box-body -->
  </div>
</div>

<?php } ?>
<?php if($technologiesf->num_rows() > 0) { ?>
<div class="col-md-6">
  <div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title">Top Web Frameworks</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
  
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped">
              
              <?php
                foreach ($technologiesf->result() as $row) 
                {
              ?>
              <tr>
                <td width="50px"><img style="height:30px;" src="<?php echo base_url(); ?>assets/images/icons/<?php echo $row->icon; ?>"></td>
                <td>
                  <strong><?php echo ($row->name); ?></strong>
                  <div class="text-muted"><?php echo ($row->tag1); ?></div>
                  </td>
              </tr>
              <?php
            
            }
            ?>
            </table>
      </div><!-- /.box-body -->
  </div>
</div>


<?php } ?>
<?php if($isp->num_rows() > 0) { ?>

<div class="col-md-6">
  <div class="box box-">
    <div class="box-header with-border">
      <h3 class="box-title">Top ISP</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
  
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped">
              
              <?php
                $i=0;
                foreach ($isp->result() as $row) 
                {
                  $i++;
              ?>
              <tr>
                <td width="50px" valign="middle" align="center">
                  <h1 style="padding:0;margin:0;color:rgba(0,0,0,.2);"><?php echo $i; ?></h1>
                </td>
                <td>
                  <strong><?php echo ($row->isp); ?></strong>
                  <div class="text-muted"><?php echo ($row->country); ?></div>
                  </td>
              </tr>
              <?php
            
            }
            ?>
            </table>
      </div><!-- /.box-body -->
  </div>
</div>
<?php } ?>



<div class="col-md-6">
  <div class="box box-">
    <div class="box-header with-border">
      <h3 class="box-title">Top Sites</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
  
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped">
              
              <?php
                foreach ($topsites->result() as $row) 
                {
              ?>
              <tr>
                   <td width="50px" valign="middle" align="center" style=" vertical-align:middle;text-align: center;">
                   <img  style="height:20px;" src="https://www.google.com/s2/favicons?domain=<?php echo $row->url; ?>"></td>
                <td class="truncate">
                  <strong class="truncate"><?php echo ($row->metaTitle); ?></strong>
                 <div class="text-muted truncate"><a href="<?php echo base_url(); ?><?php echo ($row->url); ?>"><?php echo ($row->url); ?></a></div>

                  </td>
              </tr>
              <?php
            
            }
            ?>
            </table>
      </div><!-- /.box-body -->
  </div>
</div>

<div class="col-md-6">
  <div class="box box-">
    <div class="box-header with-border">
      <h3 class="box-title">Top Sites with AMP</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
  
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped">
              
              <?php
                foreach ($topsitesAMP->result() as $row) 
                {
              ?>
              <tr>
                   <td width="50px" valign="middle" align="center" style=" vertical-align:middle;text-align: center;">
                   <img  style="height:20px;" src="https://www.google.com/s2/favicons?domain=<?php echo $row->url; ?>"></td>
                <td class="truncate">
                  <strong class="truncate"><?php echo ($row->metaTitle); ?></strong>
                    <div class="text-muted truncate"><a href="<?php echo base_url(); ?><?php echo ($row->url); ?>"><?php echo ($row->url); ?></a></div>

                  </td>
              </tr>
              <?php
            
            }
            ?>
            </table>
      </div><!-- /.box-body -->
  </div>
</div>


<div class="col-md-6">
  <div class="box box-">
    <div class="box-header with-border">
      <h3 class="box-title">Top Fastest Website (Desktop)</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
  
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped">
              
              <?php
                foreach ($topsitespsd->result() as $key => $row) 
                {
                  if(!$row->metaTitle)
                    $row->metaTitle = '-'
              ?>
              <tr>
                     <td width="50px" valign="middle" align="center">
                  <h1 style="padding:0;margin:0;color:rgba(0,0,0,.2);"><?php echo $key+1; ?></h1>
                </td>
                <td class="truncate">
                  <strong class="truncate"><?php echo ($row->metaTitle); ?></strong>
                  <div class="text-muted truncate"><a href="<?php echo base_url(); ?><?php echo ($row->url); ?>"><?php echo ($row->url); ?></a></div>
                  </td>
              </tr>
              <?php
            
            }
            ?>
            </table>
      </div><!-- /.box-body -->
  </div>
</div>


<div class="col-md-6">
  <div class="box box-">
    <div class="box-header with-border">
      <h3 class="box-title">Top Fastest Website (Mobile)</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
  
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped">
              
              <?php
                foreach ($topsitespsm->result() as $key => $row) 
                {
                  if(!$row->metaTitle)
                    $row->metaTitle = '-'
              ?>
              <tr>
                <td width="50px" valign="middle" align="center">
                  <h1 style="padding:0;margin:0;color:rgba(0,0,0,.2);"><?php echo $key+1; ?></h1>
                </td>
                <td class="truncate">
                  <strong class="truncate"><?php echo ($row->metaTitle); ?></strong>
                  <div class="text-muted truncate"><a href="<?php echo base_url(); ?><?php echo ($row->url); ?>"><?php echo ($row->url); ?></a></div>
                  </td>
              </tr>
              <?php
            
            }
            ?>
            </table>
      </div><!-- /.box-body -->
  </div>
</div>

<div class="col-md-6">
  <div class="box box-">
    <div class="box-header with-border">
      <h3 class="box-title">Top Alexa Rank</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
  
      <div class="box-body">
      <table class="table table-bordered table-hover table-striped">
              
              <?php
                foreach ($topsitesal->result() as $key => $row) 
                {
                  if(!$row->metaTitle)
                    $row->metaTitle = '-'
              ?>
              <tr>
                <td width="50px" valign="middle" align="center">
                  <h1 style="padding:0;margin:0;color:rgba(0,0,0,.2);"><?php echo $key+1; ?></h1>
                </td>
                <td class="truncate">
                  <strong class="truncate"><?php echo ($row->metaTitle); ?></strong>
                  <div class="text-muted truncate"><a href="<?php echo base_url(); ?><?php echo ($row->url); ?>"><?php echo ($row->url); ?></a></div>
                  </td>
              </tr>
              <?php
            
            }
            ?>
            </table>
      </div><!-- /.box-body -->
  </div>
</div>

</div>
 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script>
<?php

          foreach ($registered->result() as $row) {
            $data = "{y:'". $row->month."',a:".$row->n."},".$data;           
            
          }
          $data = substr($data ,0,-1);
           
?>
$(function () {
      
    $('.popover-class').popover();
                  //BAR CHART
                var bar = new Morris.Area({
                    element: 'bar-chart',
                    resize: true,
                    data: [
                       <?php echo $data ; ?>
                    ],                    
                    xkey: 'y',
                    parseTime:false,
                    ykeys: ['a'],
                    labels: ['Users'],
                    hideHover: 'auto'
                });

});
</script>
