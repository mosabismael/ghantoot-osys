
function Upload() {
	//Reference the FileUpload element.
	var fileUpload = document.getElementById("materialfile");
	
	//Validate whether File is valid Excel file.
	var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
	if (regex.test(fileUpload.value.toLowerCase())) {
		if (typeof (FileReader) != "undefined") {
			var reader = new FileReader();
			
			//For Browsers other than IE.
			if (reader.readAsBinaryString) {
				reader.onload = function (e) {
					ProcessExcel(e.target.result);
				};
				reader.readAsBinaryString(fileUpload.files[0]);
                } else {
				//For IE Browser.
				reader.onload = function (e) {
					var data = "";
					var bytes = new Uint8Array(e.target.result);
					for (var i = 0; i < bytes.byteLength; i++) {
						data += String.fromCharCode(bytes[i]);
					}
					ProcessExcel(data);
				};
				reader.readAsArrayBuffer(fileUpload.files[0]);
			}
            } else {
			alert("This browser does not support HTML5.");
		}
        } else {
		alert("Please upload a valid Excel file.");
	}
};
function ProcessExcel(data) {
	//Read the Excel File data.
	var workbook = XLSX.read(data, {
		type: 'binary'
	});
	
	//Fetch the name of First Sheet.
	var firstSheet = workbook.SheetNames[0];
	
	//Read all rows from First Sheet into an JSON array.
	var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
	
	
	
	//Add the data rows from Excel file.
	var profile = "";
	
	for (var i = 0; i < excelRows.length; i++) {
		//Add the data row.
		if(excelRows[i].Grade){
			if(excelRows[i].Grade == 'Total'){
				$.ajax({
					type: "GET",
					url: "../ui_sales_estimate/projects_estimate/export_material_excel.php",
					data     :{ 'profile': profile , 'level1_id':$('#level1_id').val()},
					dataType :"json",
					success: function(response) {
						alert("success");
						
					},
					error:function(error){
						//alert("error");
					}
				});
			}
			if(excelRows[i].Profile){
				profile = excelRows[i].Profile
			}
			
		}
		
		
	}
	
};

