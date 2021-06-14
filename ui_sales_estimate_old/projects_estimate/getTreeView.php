

<div class="content all-view">
	
	<div class = "tf-tree">					
		<ul>
			<li>
				<?php
					$qu_hr_employees_sel = "SELECT * FROM  `z_project` WHERE `project_id` = $project_id";
					$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
					$hr_employees_DATA;
					if(mysqli_num_rows($qu_hr_employees_EXE)){
						$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
						$project_name = $hr_employees_DATA['project_name'];
					?>
					<span class="tf-nc"><?=$project_name?></span>
					<ul>
						
						<?php
							$qu_level1_sel = "SELECT * FROM  `z_project_level1` WHERE `project_id` = $project_id";
							$qu_level1_EXE = mysqli_query($KONN, $qu_level1_sel);
							if(mysqli_num_rows($qu_level1_EXE)){
								while($type_REC = mysqli_fetch_assoc($qu_level1_EXE)){
									$level1_name = $type_REC['level1_name'];
									$level1_id = $type_REC['level1_id'];
								?>
								<li><span class="tf-nc" onclick = "set_tabber(1);loadLevel0Data(<?=$project_id?>);"><?=$level1_name?></span>
									
									<ul>
										
										<?php
											$qu_level2_sel = "SELECT * FROM  `z_project_level2` WHERE `level1_id` = $level1_id";
											$qu_level2_EXE = mysqli_query($KONN, $qu_level2_sel);
											if(mysqli_num_rows($qu_level2_EXE)){
												while($type_REC = mysqli_fetch_assoc($qu_level2_EXE)){
													$level2_name = $type_REC['level2_name'];
													$level2_id = $type_REC['level2_id'];
												?>
												<li><span class="tf-nc" onclick = "set_tabber(2);loadLevel1Data(<?=$level1_id?>, '<?=$level1_name?>');"><?=$level2_name?></span>
													
													<ul>
														
														<?php
															$qu_level3_sel = "SELECT * FROM  `z_project_level3` WHERE `level2_id` = $level2_id";
															$qu_level3_EXE = mysqli_query($KONN, $qu_level3_sel);
															if(mysqli_num_rows($qu_level3_EXE)){
																while($type_REC = mysqli_fetch_assoc($qu_level3_EXE)){
																	$level3_name = $type_REC['level3_name'];
																	$level3_id = $type_REC['level3_id'];
																?>
																<li><span class="tf-nc" onclick = "set_tabber(3);loadLevel2Data(<?=$level2_id?>, '<?=$level2_name?>');"><?=$level3_name?></span>
																	
																	<ul>
																		
																		<?php
																			$qu_level4_sel = "SELECT * FROM  `z_project_level4` WHERE `level3_id` = $level3_id";
																			$qu_level4_EXE = mysqli_query($KONN, $qu_level4_sel);
																			if(mysqli_num_rows($qu_level4_EXE)){
																				while($type_REC = mysqli_fetch_assoc($qu_level4_EXE)){
																					$level4_name = $type_REC['level4_name'];
																					$level4_id = $type_REC['level4_id'];
																				?>
																				<li><span class="tf-nc" onclick = "set_tabber(4);loadLevel3Data(<?=$level3_id?>, '<?=$level3_name?>');"><?=$level4_name?></span>
																					<ul>
																						
																						<?php
																							$qu_level5_sel = "SELECT * FROM  `z_project_level5` WHERE `level4_id` = $level4_id";
																							$qu_level5_EXE = mysqli_query($KONN, $qu_level5_sel);
																							if(mysqli_num_rows($qu_level5_EXE)){
																								while($type_REC = mysqli_fetch_assoc($qu_level5_EXE)){
																									$level5_name = $type_REC['level5_name'];
																									$level5_id = $type_REC['level5_id'];
																								?>
																								<li><span class="tf-nc" onclick = "set_tabber(5);loadLevel4Data(<?=$level4_id?>, '<?=$level4_name?>');"><?=$level5_name?></span>
																								<ul>
																									<?php
																										$qu_boq5_sel = "SELECT * FROM  `z_boq` boq , z_boq_details details WHERE boq.boq_id = details.boq_id and boq.level1_id = $level1_id and boq.level2_id = $level2_id and boq.level3_id = $level3_id and boq.level4_id = $level4_id and  boq.level5_id = $level5_id;";
																										$qu_boq5_EXE = mysqli_query($KONN, $qu_boq5_sel);
																										if(mysqli_num_rows($qu_boq5_EXE)){
																											while($type_REC = mysqli_fetch_assoc($qu_boq5_EXE)){
																												$boq_name = $type_REC['boq_name'];
																												$boq_total = $type_REC['boq_total'];
																											?>
																											<li><?=$boq_name?> - <?=$boq_total?> AED</li>
																											<?php
																											}
																										}
																									?>
																								</ul>
																								
																								<?php     
																								}
																							}
																							else{
																								
																								$qu_boq4_sel = "SELECT * FROM  `z_boq` boq , z_boq_details details WHERE boq.boq_id = details.boq_id and boq.level1_id = $level1_id and boq.level2_id = $level2_id and boq.level3_id = $level3_id and boq.level4_id = $level4_id and  boq.level5_id = 0;";
																								$qu_boq4_EXE = mysqli_query($KONN, $qu_boq4_sel);
																								if(mysqli_num_rows($qu_boq4_EXE)){
																									while($type_REC = mysqli_fetch_assoc($qu_boq4_EXE)){
																										$boq_name = $type_REC['boq_name'];
																										$boq_total = $type_REC['boq_total'];
																									?>
																									<li><?=$boq_name?> - <?=$boq_total?> AED</li>
																									<?php
																									}
																								}
																								
																							}
																						?>
																						
																					</ul>
																					
																				</li>
																				<?php     
																				}
																			}
																			else{
																				$qu_boq3_sel = "SELECT * FROM  `z_boq` boq , z_boq_details details WHERE boq.boq_id = details.boq_id and boq.level1_id = $level1_id and boq.level2_id = $level2_id and boq.level3_id = $level3_id and boq.level4_id = 0 and  boq.level5_id = 0;";
																				$qu_boq3_EXE = mysqli_query($KONN, $qu_boq3_sel);
																				if(mysqli_num_rows($qu_boq3_EXE)){
																					while($type_REC = mysqli_fetch_assoc($qu_boq3_EXE)){
																						$boq_name = $type_REC['boq_name'];
																						$boq_total = $type_REC['boq_total'];
																					?>
																					<li><?=$boq_name?> - <?=$boq_total?> AED</li>
																					<?php
																					}
																				}
																			}
																		?>
																		
																	</ul>
																</li>
																<?php     
																}
															}
															else{
																$qu_boq2_sel = "SELECT * FROM  `z_boq` boq , z_boq_details details WHERE boq.boq_id = details.boq_id and boq.level1_id = $level1_id and boq.level2_id = $level2_id and boq.level3_id = 0 and boq.level4_id = 0 and  boq.level5_id = 0;";
																$qu_boq2_EXE = mysqli_query($KONN, $qu_boq2_sel);
																if(mysqli_num_rows($qu_boq2_EXE)){
																	while($type_REC = mysqli_fetch_assoc($qu_boq2_EXE)){
																		$boq_name = $type_REC['boq_name'];
																		$boq_total = $type_REC['boq_total'];
																	?>
																	<li><?=$boq_name?> - <?=$boq_total?> AED</li>
																	<?php
																	}
																}
															}
														?>
														
													</ul>
												</li>
												<?php     
												}
											}
											else{
												$qu_boq1_sel = "SELECT * FROM  `z_boq` boq , z_boq_details details WHERE boq.boq_id = details.boq_id and boq.level1_id = $level1_id and boq.level2_id = 0 and boq.level3_id = 0 and boq.level4_id = 0 and  boq.level5_id = 0;";
												$qu_boq1_EXE = mysqli_query($KONN, $qu_boq1_sel);
												if(mysqli_num_rows($qu_boq1_EXE)){
													while($type_REC = mysqli_fetch_assoc($qu_boq1_EXE)){
														$boq_name = $type_REC['boq_name'];
														$boq_total = $type_REC['boq_total'];
													?>
													<li><?=$boq_name?> - <?=$boq_total?> AED</li>
													<?php
													}
												}	
											}
										?>
										
									</ul>
								</li>
								<?php     
								}
							}
						?>
					</a></li>
			</ul>
			
			
			
		</li>
	</ul>
</div>		

</div>

<?php
}
?>

<div class="zero"></div>
