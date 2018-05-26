@if(isset($what) and isset($tableHeaders) and isset($tableContent) and isset($where))
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3>Listado de {{ $what }}:</h3>
        <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
        <script>
        $(document).ready(
            function(){
                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        </script>
    </div>
    <div class="panel-body" style="overflow: scroll;">
        <table class="table table-responsive table-hover">
            <thead>
                @foreach ($tableHeaders as $title)
                    <th>{{ $title }}</th>
                @endforeach                
            </thead>            
            <tbody id="myTable">
                @foreach ($tableContent as $row)
                <tr>
                    @foreach ($row as $key=>$elem)
                        @if($key!=='deleted')
                            <th>{{ $elem }}</th>
                        @endif
                    @endforeach                    
                        {{-- listBtn uses $where--}}                        
                        <th style="min-width:250px;">
                            @include('forms.listBtn',['id'=>$row['id'],'deleted'=>$row['deleted']])                            
                        </th>
                </tr>
                @endforeach                
            </tbody>            
        </table>
        @if(isset($links))
            <center>{{ $links }}</center>
        @endif
    </div>
</div>
@endif