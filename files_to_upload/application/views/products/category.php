<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title"> <?php echo $this->lang->line('Product Category') ?> <a href="<?php echo base_url('productcategory/add') ?>" class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') . ' ' . $this->lang->line('Category') ?>
                </a> <a href="<?php echo base_url('productcategory/add_sub') ?>" class="btn btn-blue btn-sm rounded">
                    <?php echo $this->lang->line('Add new') . ' - ' . $this->lang->line('Sub') . ' ' . $this->lang->line('Category') ?>
                </a>
            </h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">

                <table id="catgtable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Total Products') ?></th>
                            <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                            <th><?php echo $this->lang->line('Worth (Sales/Stock)') ?></th>
                            <th><?php echo $this->lang->line('Action') ?></th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($cat as $row) {
                            $cid = $row['id'];
                            $title = $row['title'];
                            $total = $row['pc'];

                            $qty = +$row['qty'];
                            $salessum = amountExchange($row['salessum'], 0, $this->aauth->get_user()->loc);
                            $worthsum = amountExchange($row['worthsum'], 0, $this->aauth->get_user()->loc);
                            echo "<tr>
                    <td>$i</td>
                    <td><a href='" . base_url("productcategory/view?id=$cid") . "' >$title</a></td>
                    <td>$total</td>
                    <td>$qty</td>
                    <td>$salessum/$worthsum</td>
                    <td><a href='" . base_url("productcategory/view?id=$cid") . "' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> " . $this->lang->line('View') . "</a>&nbsp; <a class='btn btn-blue  btn-sm' href='" . base_url() . "productcategory/report_product?id=" . $cid . "' target='_blank'> <span class='fa fa-pie-chart'></span> " . $this->lang->line('Reports') . "</a>&nbsp;  <a href='" . base_url("productcategory/edit?id=$cid") . "' class='btn btn-warning btn-sm'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a>&nbsp;<a href='#' data-object-id='" . $cid . "' class='btn btn-danger btn-sm delete-object' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";


                            $i++;
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Total Products') ?></th>
                            <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                            <th><?php echo $this->lang->line('Worth (Sales/Stock)') ?></th>
                            <th><?php echo $this->lang->line('Action') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="card-body">

                <table id="itemTable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Total Products') ?></th>
                            <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                            <th><?php echo $this->lang->line('Worth (Sales/Stock)') ?></th>

                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Total Products') ?></th>
                            <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                            <th><?php echo $this->lang->line('Worth (Sales/Stock)') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var subCategoryTable;

        function destroyChild2(row) {
            var table = $("table", row.child());
            table.detach();
            table.DataTable().destroy();

            // And then hide the row
            row.child.hide();
        }

        function createChild2(row) {
            // This is the table we'll convert into a DataTable
            var rowData = row.data();

            var table = $('<table class="display" width="100%"/>');

            // Display it the child row
            row.child(table).show();
            // Initialise as a DataTable
            var subSubCategoryEditor = new $.fn.dataTable.Editor({
                ajax: {
                    "url": "<?php
                            echo site_url('application/controllers/subcategoryeditor') ?>",

                    // "dataSrc": "",
                    data: function(d) {
                        d.rel_id = rowData.id;
                    }
                    // data: function(d) {
                    //     console.log(d);
                    //     d.id = rowData.id;
                    // }
                },
                table: table,
                idSrc: 'id',
                fields: [{
                        label: 'Category Name:',
                        name: 'geopos_product_cat.title',
                        data: 'title'
                    }, {
                        label: "Category Description:",
                        name: "geopos_product_cat.extra",
                        data: 'extra'
                    },
                    {
                        name: "rel_id",
                        type: 'hidden',
                        def: rowData.id,
                        data: 'rel_id'
                    },
                    {
                        name: 'c_type',
                        type: 'hidden',
                        def: '2',
                        data: 'c_type'
                    }
                ]
            });
            debugger;
            var subSubCategoryTable = table.DataTable({
                dom: 'Bfrtip',
                "ajax": {
                    url: 'productcategory/getSubCategories?id=' + row.data().id,
                    "dataSrc": '',
                    type: "post",

                },
                // success: function(json) {
                //     console.log(json);
                //     success(json);
                // },
                rowId: 'id',
                idSrc: 'cat_id',
                order: [1, 'asc'],
                select: {
                    style: 'os',
                    selector: 'td:not(:first-child)'
                },
                columns: [{
                        className: 'details-s-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                        width: '10%'
                    },
                    {
                        title: 'Sub Category Title',
                        data: 'geopos_product_cat.title',
                        render: function(val, type, row) {
                            return row.title
                        },
                    },
                    {
                        data: 'geopos_product_cat.id',
                        visible: false,
                        render: function(val, type, row) {
                            return row.id
                        },
                    },
                    {
                        title: 'Total Products',
                        data: 'geopos_product_cat.pc',
                        render: function(val, type, row) {
                            return row.pc
                        },
                    },
                    {
                        title: 'Stock Quantity',
                        data: 'geopos_product_cat.qty',

                        render: function(val, type, row) {
                            return row.qty
                        },
                    },
                    {
                        title: 'Worth(Sales/Stock)',
                        render: function(val, type, row) {
                            if (row.salessum != null && row.worthsum != null) {
                                $ret = '$' + row.salessum + '/$' + row.worthsum;
                            } else {
                                $ret = '$' + 0.00 + '/$' + 0.00
                            }
                            return $ret
                        },
                    },
                    {

                        // label: "Category:",
                        name: "geopos_product_cat.rel_id",
                        visible: false,
                        data: 'rel_id',

                        render: function(val, type, row) {
                            return row.rel_id
                        },

                    },
                    {

                        // label: "Category:",
                        name: "geopos_product_cat.c_type",
                        visible: false,
                        data: 'c_type',

                        render: function(val, type, row) {
                            return row.c_type
                        },

                    },
                ],
                select: true,
                buttons: [{
                        extend: "create",
                        editor: subSubCategoryEditor,
                        formTitle: function(editor, dt) {
                            // Get the data for the row and use a property from it in the
                            // form title
                            debugger;
                            var rowData = dt.row({
                                selected: true
                            }).data();

                        }
                    },
                    {
                        extend: "edit",
                        editor: subSubCategoryEditor,
                        formTitle: function(editor, dt) {
                            // Get the data for the row and use a property from it in the
                            // form title
                            debugger;
                            var rowData = dt.row({
                                selected: true
                            }).data();

                            return 'Editing data for ' + rowData.first_name;
                        }
                    },
                    {
                        extend: "remove",
                        editor: subSubCategoryEditor
                    }
                ]
            });
            subSubCategoryEditor.on('submitSuccess', function(e, json, data, action) {
                row.ajax.reload(function() {
                    $(row.cell(row.id(true), 0).node()).click();
                });
            });
            console.log(subSubCategoryEditor);
        }
        var rowData;
        function createChild(row) {
            // This is the table we'll convert into a DataTable
            rowData = row.data();
            debugger;
            console.log(row);
            var table = $('<table class="display subCategory' + rowData.id + '" width="100%"/>');

            // Display it the child row
            row.child(table).show();
            // Initialise as a DataTable

            $('.subCategory' + rowData.id + ' tbody').on('click', 'td.details-sub-control', function() {
                // debugger;
                var tr = $(this).closest('tr');
                var row = subCategoryTable.row(tr);
                // console.log(tr);
                // console.log(row);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    destroyChild2(row);
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    createChild2(row);
                    tr.addClass('shown');
                }
            });



            var subCategoryEditor = new $.fn.dataTable.Editor({
                ajax: {
                    "url": "<?php
                            echo site_url('application/controllers/subcategoryeditor') ?>",

                    // "dataSrc": "",
                    data: function(d) {
                        d.rel_id = rowData.id;
                    }
                    // data: function(d) {
                    //     console.log(d);
                    //     d.id = rowData.id;
                    // }
                },
                table: table,
                idSrc: 'id',
                fields: [{
                        label: 'Category Name:',
                        name: 'geopos_product_cat.title',
                        data: 'title'
                    }, {
                        label: "Category Description:",
                        name: "geopos_product_cat.extra",
                        data: 'extra'
                    },
                    {
                        name: "rel_id",
                        type: 'hidden',
                        def: rowData.id,
                        data: 'rel_id'
                    },
                    {
                        name: 'c_type',
                        type: 'hidden',
                        def: '1',
                        data: 'c_type'
                    }
                ]
            });
            debugger;
            subCategoryTable = table.DataTable({
                dom: 'Bfrtip',
                "ajax": {
                    url: 'productcategory/getSubCategories?id=' + row.data().id,
                    "dataSrc": '',
                    type: "post",

                },
                // success: function(json) {
                //     console.log(json);
                //     success(json);
                // },
                rowId: 'id',
                idSrc: 'cat_id',
                order: [1, 'asc'],
                select: {
                    style: 'os',
                    selector: 'td:not(:first-child)'
                },
                columns: [{
                        className: 'details-sub-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                        width: '10%'
                    },
                    {
                        title: 'Sub Category Title',
                        data: 'geopos_product_cat.title',
                        render: function(val, type, row) {
                            return row.title
                        },
                    },
                    {
                        data: 'geopos_product_cat.id',
                        visible: false,
                        render: function(val, type, row) {
                            return row.id
                        },
                    },
                    {
                        title: 'Total Products',
                        data: 'geopos_product_cat.pc',
                        render: function(val, type, row) {
                            return row.pc
                        },
                    },
                    {
                        title: 'Stock Quantity',
                        data: 'geopos_product_cat.qty',

                        render: function(val, type, row) {
                            return row.qty
                        },
                    },
                    {
                        title: 'Worth(Sales/Stock)',
                        render: function(val, type, row) {
                            if (row.salessum != null && row.worthsum != null) {
                                $ret = '$' + row.salessum + '/$' + row.worthsum;
                            } else {
                                $ret = '$' + 0.00 + '/$' + 0.00
                            }
                            return $ret
                        },
                    },
                    {

                        // label: "Category:",
                        name: "geopos_product_cat.rel_id",
                        visible: false,
                        data: 'rel_id',

                        render: function(val, type, row) {
                            return row.rel_id
                        },

                    },
                    {

                        // label: "Category:",
                        name: "geopos_product_cat.c_type",
                        visible: false,
                        data: 'c_type',

                        render: function(val, type, row) {
                            return row.c_type
                        },

                    },
                ],
                // select: true,
                buttons: [{
                        extend: "create",
                        editor: subCategoryEditor,
                        formTitle: function(editor, dt) {
                            // Get the data for the row and use a property from it in the
                            // form title
                            debugger;
                            var rowData = dt.row({
                                selected: true
                            }).data();

                        }
                    },
                    {
                        extend: "edit",
                        editor: subCategoryEditor,
                        formTitle: function(editor, dt) {
                            // Get the data for the row and use a property from it in the
                            // form title
                            debugger;
                            var rowData = dt.row({
                                selected: true
                            }).data();

                            return 'Editing data for ' + rowData.first_name;
                        }
                    },
                    {
                        extend: "remove",
                        editor: subCategoryEditor
                    }
                ]
            });
            subCategoryEditor.on('submitSuccess', function(e, json, data, action) {
                row.ajax.reload(function() {
                    $(row.cell(row.id(true), 0).node()).click();
                });
            });
            console.log(subCategoryEditor);
        }

        function updateChild(row) {
            $("table", row.child())
                .DataTable()
                .ajax.reload();
        }

        function destroyChild(row) {
            var table = $("table", row.child());
            table.detach();
            table.DataTable().destroy();

            // And then hide the row
            row.child.hide();
        }
        // var rowData = row.data();
        $(document).ready(function() {

            //datatables
            //code added by nouman
            var editor = new $.fn.dataTable.Editor({
                "ajax": {
                    "url": "<?php if (isset($sub)) {
                                $t = '1';
                            } else {
                                $t = '0';
                            }
                            echo site_url('application/controllers/editortesting')
                            //  . '?id=' . $id . '&sub=' . $t;  
                            ?>",
                    "type": "POST",
                    'data': {
                        '<?= $this->security->get_csrf_token_name() ?>': crsf_hash
                    }
                },
                table: '#itemTable',
                idSrc: 'id',
                fields: [{
                        label: 'Category Name:',
                        name: 'title'
                    }, {
                        label: "Category Description:",
                        name: "extra"
                    },
                    {
                        name: 'c_type',
                        type: 'hidden',
                        def: '0'
                    }
                ]
            });
            console.log(editor);
            $.fn.dataTable.ext.errMode = function(obj, param, err) {
                var tableId = obj.sTableId;
                // console.log('Handling DataTable issue of Table ' + tableId);
            };
            var categoryTable = $('#itemTable').DataTable({
                dom: 'Bfrtip',
                "ajax": {
                    url: 'productcategory/getCategories',
                    "dataSrc": ""
                },
                success: function(response) {
                    // console.log(response);
                    var json = JSON.parse(response);
                    var d = json.data;
                    json.data = [d];

                    success(response);
                },
                order: [1, 'asc'],
                select: {
                    style: 'os',
                    selector: 'td:not(:first-child)'
                },
                columns: [{
                        className: 'details-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                        width: '10%'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'pc'
                    },
                    {
                        data: 'qty'
                    },
                    {

                        render: function(val, type, row) {
                            if (row.salessum != null && row.worthsum != null) {
                                $ret = '$' + row.salessum + '/$' + row.worthsum;
                            } else {
                                $ret = '$' + 0.00 + '/$' + 0.00
                            }
                            return $ret
                        },
                    },
                    {
                        visible: false,
                        data: 'extra'
                    }
                ],
                // select: true,
                buttons: [{
                        extend: "create",
                        editor: editor
                    },
                    {
                        extend: "edit",
                        editor: editor
                    },
                    {
                        extend: "remove",
                        editor: editor
                    }
                ]
            });
            // console.log(editor);
            // debugger;
            $('#itemTable tbody').on('click', 'td.details-control', function() {
                // debugger;
                var tr = $(this).closest('tr');
                var row = categoryTable.row(tr);
                // console.log(tr);
                // console.log(row);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    destroyChild(row);
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    createChild(row);
                    tr.addClass('shown');
                }
            });



            var category = $('#catgtable').DataTable({
                responsive: true,
                <?php datatable_lang(); ?> dom: 'Blfrtip',
                select: {
                    style: 'os',
                    selector: 'td:not(:first-child)'
                },
                buttons: [{
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    // {
                    //         extend: 'create',
                    //         editor: categoryEditor
                    //     },
                    //     {
                    //         extend: 'edit',
                    //         editor: categoryEditor
                    //     },
                    //     {
                    //         extend: 'remove',
                    //         editor: categoryEditor
                    //     }
                ],

            });
            console.log(category);

        });
    </script>
    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this product category') ?></strong></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="productcategory/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>