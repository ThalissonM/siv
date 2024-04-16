
  <select id="selectMotorista"  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
  </select>


<script>
$(function(){
$('#selectMotorista').select2(
    {
        ajax:{
            url:'{{(URL('motoristas/getdata'))}}',
            type:'get',
            dataType:'json',
            delay:250,
            data:function(params)
            {
                return {
                    searchItem:params.term,
                    page:params.page
                }
            },
            processResults:function(data,params)
            {
                params.page=params.page||1;
                return {
                    results:data.data,
                    pagination:{
                        more:data.last_page!=params.page
                    }
                }
            },
            cache:true,
        },
        placeholder:'Buscar...',
        templateResult:templateResult,

    }
)
})

function templateResult(data){
    if(data.loading)
    {
        return data.text
    }
    return data.nome
}
</script>