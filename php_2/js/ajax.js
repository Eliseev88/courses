<script type="text/javascript">
	$(document).ready(function (){
        let offset = 8;
		$('#show_more').click(function (event){
            event.preventDefault()
				$.ajax({
					method: "post",
					url: "./engine/show_more.php",
					data: {"offset" : offset},
					dataType: "text",
					success: function (response){
                        if(response.length){
                            $("#main_cat").append(response)
                            offset += 8
                        } else {
                            $("#show_more").attr("disabled",true)
                        }  
					}
				})	
		})	
	})

</script>
