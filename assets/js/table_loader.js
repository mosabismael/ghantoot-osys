
var curPageBatchStart = 1;
var curPageBatchEnd   = 10;

function showPrePageBatch( controller, showPerPager, totPagers ){
	if( totPagers > 1 ){
		$('#prePatchBtn').show();
		var nwStart = curPageBatchStart - 10;
		if( nwStart <= 1 ){
			nwStart = 1;
			//hide pre btn
			$('#prePatchBtn').hide();
			$('#nextPatchBtn').show();
		}
		var nwEnd   = nwStart + 9;
		$('.imVarPager').each( function(){
			$(this).remove();
		} );
		
		for( i=nwStart ; i <= nwEnd ; i++ ){
			var iView = '' + i;
			if( i < 10 ){
				iView = '0' + i;
			}
			if( i <= totPagers ){
				var nwPager = '<div onclick="loadTableData( ' + i + ', ' + showPerPager + ',' + "'" +  controller + "'" + ' );" class="pageNum imVarPager pn-' + i + '">' + iView + '</div>';
				$('#addPagerPoint').before( nwPager );
			}
			
		}
		if( nwEnd <= totPagers ){
			$('#nextPatchBtn').show();
		}
		
		curPageBatchStart = nwStart;
		curPageBatchEnd   = nwEnd;
	}
}

function showNextPageBatch( controller, showPerPager, totPagers ){
	if( totPagers > 1 ){
		$('#nextPatchBtn').show();
		var nwStart = curPageBatchStart + 10;
		var nwEnd   = curPageBatchEnd + 10;
		if( nwEnd > totPagers ){
			nwEnd =  totPagers;
			$('#nextPatchBtn').hide();
		}
		
		console.log('start=' + nwStart);
		console.log('end=' + nwEnd);
		if(nwStart < nwEnd){
			
			if( nwEnd > totPagers ){
				$('#nextPatchBtn').hide();
				$('#prePatchBtn').show();
			}
			
			$('.imVarPager').each( function(){
				$(this).remove();
			} );

			for( i=nwStart ; i <= nwEnd ; i++ ){
				var iView = '' + i;
				if( i < 10 ){
					iView = '0' + i;
				}
				if( i <= totPagers ){
					var nwPager = '<div onclick="loadTableData( ' + i + ', ' + showPerPager + ',' + "'" +  controller + "'" + ' );" class="pageNum imVarPager pn-' + i + '">' + iView + '</div>';
					$('#addPagerPoint').before( nwPager );
				}
			}
			if( nwStart >= 1 ){
				$('#prePatchBtn').show();
			}
			curPageBatchStart = nwStart;
			curPageBatchEnd   = nwEnd;
			
		}

	}
}


function loadTableData( pager, showPerPager, controllerApi ){
	start_loader();
	$.ajax({
		url      :"../controllers/" + controllerApi,
		data     :{ 'page': pager, 'showperpage': showPerPager, 'cond': sthsSearchCond , 'rearrange' : rearrange},
		dataType :"json",
		type     :'POST',
		success  :function( res ){
				end_loader();
				console.log(res.length);
				
				if( res.length != 0 ){
					
					bindData( res );
					
				} else {
					
					var ress = '<div class="tr"><div class="td">NO Data Found</div></div>';
					$('#tableBody').append( ress );
					
				}
				
				
				
				$('.tablePagination .activePage').removeClass('activePage');
				$('.tablePagination .pn-' + pager).addClass('activePage');
			},
		error    :function( rr ){
				end_loader();
				alert('Data Error No: 5467653');
			},
		});
}

if (typeof sthsSearchCond === 'undefined') {
	sthsSearchCond = "";
}
if (typeof rearrange === 'undefined') {
	rearrange = "";
}

if (typeof thsPage !== 'undefined') {
	loadTableData( 1, 20, thsPage );
}







$('#prePatchBtn').hide();