<?php $this->load->view('shared/header');?>
	
	<section class="app">
	
		<div class="container">
			
			<?php if( $this->session->flashdata('success_message') != '' ):?>
			<div class="alert alert-success">
				<button class="close fui-cross" data-dismiss="alert"></button>
			  	<h4>Yay!</h4>
			  	<div><?php echo $this->session->flashdata('success_message');?></div>
			</div>
			<?php endif;?>
			
			<?php if( $this->session->flashdata('error_message') != '' ):?>
			<div class="alert alert-danger">
				<button class="close fui-cross" data-dismiss="alert"></button>
			  	<h4>Yay!</h4>
			  	<div><?php echo $this->session->flashdata('error_message');?></div>
			</div>
			<?php endif;?>
			
			<?php if( !$clients ):?>
			<div class="alert alert-info" style="margin-top: 20px">
				<button class="close fui-cross" data-dismiss="alert"></button>
			  	<h4><?php echo $this->lang->line('welcome_heading');?></h4>
			  	<?php echo $this->lang->line('welcome_message');?>
			</div>
			<?php endif;?>
			
			<div class="row" style="margin-top: 20px">
			
				<div class="col-md-12 clearfix" style="margin-bottom: 20px">
					
					<?php if( $currencies && count($currencies) > 1 ):?>
					<div class="pull-right">
						<?php echo $this->lang->line('show_amounts_in');?>: 
						<div class="btn-group">
							<button class="btn btn-inverse btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
		    					<span class="buttonText"><?php echo $default_currency->currency_shortname;?> <?php echo $default_currency->currency_sign;?></span> <span class="caret"></span>
		  					</button>
		  					<ul class="dropdown-menu dropdown-menu-inverse currencySelect" role="menu">
								<?php foreach( $currencies as $currency ):?>
								<li><a href="" data-currencyid="<?php echo $currency->currency_shortname;?>" data-currencysign="<?php echo $currency->currency_sign;?>"><?php echo $currency->currency_shortname;?> <?php echo $currency->currency_sign;?></a></li>
								<?php endforeach;?>
		  					</ul>
						</div>
					</div>
					<?php endif;?>
				
				</div><!-- /.col -->
			
			</div><!-- /.row -->
		
			<div class="dashboardWrapper" id="dashboard">
								
				<div class="row" style="margin-bottom: 40px">
			
					<div class="col-md-4">
				
						<h2>
							<?php echo $this->lang->line('total_paid');?> (<?php echo date('Y');?>)
						</h2>
				
						<div class="dashboardTotal paid text-center" id="totalPaid">
					
							<?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $default_currency->currency_sign;?><?php endif;?>
                            <?php echo $total_paid;?>
                            <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $default_currency->currency_sign;?><?php endif;?>
					
						</div>
								
					</div><!-- /.col -->
			
					<div class="col-md-4">
				
						<h2>
							<?php echo $this->lang->line('total_due');?> (<?php echo date('Y');?>)
						</h2>
				
						<div class="dashboardTotal due text-center" id="totalDue">
					
							<?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $default_currency->currency_sign;?><?php endif;?>
                            <?php echo $total_due;?>
                            <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $default_currency->currency_sign;?><?php endif;?>
					
						</div>
				
					</div><!-- /.col -->
			
					<div class="col-md-4">
				
						<h2>
							<?php echo $this->lang->line('total_past_due');?> (<?php echo date('Y');?>)
						</h2>
				
						<div class="dashboardTotal past-due text-center" id="totalPastdue">
					
							<?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $default_currency->currency_sign;?><?php endif;?>
                            <?php echo $total_pastdue;?>
                            <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $default_currency->currency_sign;?><?php endif;?>
					
						</div>
				
					</div><!-- /.col -->
			
				</div><!-- /.row -->
		
				<div class="row">
			
					<div class="col-md-8" id="div_yearlyChart">
				
						<h2><?php echo $this->lang->line('yearly_overview');?></h2>
				
						<canvas id="yearly"></canvas>
								
					</div><!-- /.col -->
			
					<div class="col-md-4" id="div_donutChart">
				
						<h2><?php echo $this->lang->line('client_overview');?></h2>
				
						<canvas id="clients" width="200"></canvas>
				
					</div><!--/.col -->
					
				</div><!-- /.row -->
		
			</div><!-- /.dashboard -->
		
		</div><!-- /.container-fluid -->
	
	</section>
	
	<!-- /.Modals -->
	<?php $this->load->view('shared/modal_account');?>
	
	<?php $this->load->view('shared/modal_apikey');?>
		
	<?php $this->load->view('shared/modal_newclient.php');?>

    <?php $this->load->view('shared/shared_javascript');?>
	
	<script src="<?php echo base_url('js/Chart.min.js');?>"></script>
	
	<script>
	
	var lineChartData = {
		labels : ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
		datasets : [
			{
				label: "<?php echo date('Y');?>",
				fillColor : "rgba(14,172,147,0.1)",
				strokeColor : "rgba(14,172,147,1)",
				pointColor : "rgba(14,172,147,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "rgba(54,73,92,0.8)",
				pointHighlightStroke : "rgba(54,73,92,1)",
				data : [<?php echo $totalsCurrentYear->Jan;?>,<?php echo $totalsCurrentYear->Feb;?>,<?php echo $totalsCurrentYear->Mar;?>,<?php echo $totalsCurrentYear->Apr;?>,<?php echo $totalsCurrentYear->May;?>,<?php echo $totalsCurrentYear->Jun;?>,<?php echo $totalsCurrentYear->Jul;?>, <?php echo $totalsCurrentYear->Aug;?>,<?php echo $totalsCurrentYear->Sep;?>,<?php echo $totalsCurrentYear->Oct;?>,<?php echo $totalsCurrentYear->Nov;?>, <?php echo $totalsCurrentYear->Dec;?>],
			},
			{
				label: "<?php echo date('Y')-1;?>",
				fillColor : "rgba(244,167,47,0)",
				strokeColor : "rgba(244,167,47,1)",
				pointColor : "rgba(217,95,6,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "rgba(54,73,92,0.8)",
				pointHighlightStroke : "rgba(54,73,92,1)",
				data : [<?php echo $totalsLastYear->Jan;?>,<?php echo $totalsLastYear->Feb;?>,<?php echo $totalsLastYear->Mar;?>,<?php echo $totalsLastYear->Apr;?>,<?php echo $totalsLastYear->May;?>,<?php echo $totalsLastYear->Jun;?>,<?php echo $totalsLastYear->Jul;?>, <?php echo $totalsLastYear->Aug;?>,<?php echo $totalsLastYear->Sep;?>,<?php echo $totalsLastYear->Oct;?>,<?php echo $totalsLastYear->Nov;?>, <?php echo $totalsLastYear->Dec;?>],
			}
			
		]

	}
	
	<?php $colors = $this->config->item('dashboard_donut_colors');?>
	
	var doughnutData = [
		
		<?php if( $clientsWithTotals ):?>
		
		<?php $counter=0;?>
		
		<?php foreach( $clientsWithTotals as $c ):?>
		
		{
			value: <?php echo $c->total_paid;?>,
			color:"<?php echo $colors[$counter][0];?>",
			highlight: "<?php echo $colors[$counter][1];?>",
			label: "<?php echo $c->client_name;?>"
		},
		<?php $counter++;?>
		<?php endforeach;?>
		
		<?php endif;?>

	];
		
	var donutColors = [
		
		<?php foreach( $colors as $color ):?>
		{
			main: "<?php echo $color[0];?>",
			second: "<?php echo $color[1];?>",
		},
		<?php endforeach;?>
		
	];
	
	
	$(function(){
		
		Chart.defaults.global.scaleFontSize = 15;
		
		var ctx = document.getElementById("yearly").getContext("2d");
		yearlyChart = new Chart(ctx).Line(lineChartData, {
			responsive: true
		});
		
		$('#div_yearlyChart').append( yearlyChart.generateLegend() )
		
		
		var ctx = document.getElementById("clients").getContext("2d");
		myDoughnut = new Chart(ctx).Doughnut(doughnutData, {
			responsive : true
		});
		
		$('#div_donutChart').append( myDoughnut.generateLegend() )
		
		//change currency
		$('.currencySelect a').on('click', function(e){
			
			e.preventDefault();
			
			var theLink = $(this);
						
			//load new dashboard details
			
			$.ajax({
				url: '<?php echo site_url('dashboard/udata/')?>/'+$(this).attr('data-currencyid'),
				method: 'get',
				dataType: 'json'
			}).done(function(ret){
								
				if( ret.code == 1 ) {
					
					$('#totalPaid').text( theLink.attr('data-currencysign')+ret.data.total_paid );
					$('#totalDue').text( theLink.attr('data-currencysign')+ret.data.total_due );
					$('#totalPastdue').text( theLink.attr('data-currencysign')+ret.data.total_pastdue );
					
					yearlyChart.destroy();
					
					var lineChartData = {
						labels : ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
						datasets : [
							{
								label: "<?php echo date('Y');?>",
								fillColor : "rgba(14,172,147,0.1)",
								strokeColor : "rgba(14,172,147,1)",
								pointColor : "rgba(14,172,147,1)",
								pointStrokeColor : "#fff",
								pointHighlightFill : "rgba(54,73,92,0.8)",
								pointHighlightStroke : "rgba(54,73,92,1)",
								data : [ret.data.totalsCurrentYear.Jan,ret.data.totalsCurrentYear.Feb,ret.data.totalsCurrentYear.Mar,ret.data.totalsCurrentYear.Apr,ret.data.totalsCurrentYear.May,ret.data.totalsCurrentYear.Jun,ret.data.totalsCurrentYear.Jul, ret.data.totalsCurrentYear.Aug,ret.data.totalsCurrentYear.Sep,ret.data.totalsCurrentYear.Oct,ret.data.totalsCurrentYear.Nov,ret.data.totalsCurrentYear.Dec],
							},
							{
								label: "<?php echo date('Y')-1;?>",
								fillColor : "rgba(244,167,47,0)",
								strokeColor : "rgba(244,167,47,1)",
								pointColor : "rgba(217,95,6,1)",
								pointStrokeColor : "#fff",
								pointHighlightFill : "rgba(54,73,92,0.8)",
								pointHighlightStroke : "rgba(54,73,92,1)",
								data : [ret.data.totalsLastYear.Jan,ret.data.totalsLastYear.Feb,ret.data.totalsLastYear.Mar,ret.data.totalsLastYear.Apr,ret.data.totalsLastYear.May,ret.data.totalsLastYear.Jun,ret.data.totalsLastYear.Jul,ret.data.totalsLastYear.Aug,ret.data.totalsLastYear.Sep,ret.data.totalsLastYear.Oct,ret.data.totalsLastYear.Nov,ret.data.totalsLastYear.Dec],
							}
			
						]
					}
					
					var ctx = document.getElementById("yearly").getContext("2d");
					yearlyChart = new Chart(ctx).Line(lineChartData, {
						responsive: true
					});
					
					myDoughnut.destroy();
					
					var doughnutData = new Array();
					
					for(x=0; x<ret.data.clientsWithTotals.length; x++) {
						
						var client = {};
												
						client.value = ret.data.clientsWithTotals[x].total_paid;
						client.color = donutColors[x].main;
						client.highlight = donutColors[x].second;
						client.label = ret.data.clientsWithTotals[x].client_name;
						
						doughnutData.push(client);
						
						//alert( ret.data.clientsWithTotals[x].client_id )
						
					}
					
					var ctx = document.getElementById("clients").getContext("2d");
					myDoughnut = new Chart(ctx).Doughnut(doughnutData, {
						responsive : true
					});
					
					theLink.closest('.btn-group').find('.buttonText').text( theLink.attr('data-currencyid') + " " + theLink.attr('data-currencysign') )
					
				}
				
			})
			
			
			
		})
		
	})
	
	</script>
  </body>
</html>