
<script>
$(document).ready(function(){
        // $('#myTable').DataTable({
        //     dom: 'Bfrtip',
        //     buttons: [
        //         'copy', 'csv', 'excel', 'pdf', 'print'
        //     ]
        // });
        $('#myTable').DataTable({
            "columnDefs" : [{"targets":3, "type":"date-eu"}],
            // columnDefs : [
            //         { type: 'time-date-sort',
            //         targets: [3],
            //     }
            // ],

        "order": [[ 0, "desc" ]],
        dom: '<"top"Bf>rt<"bottom"lip><"clear">',
        // dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ],

        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print','pageLength',
        ]

        });
});
</script>

