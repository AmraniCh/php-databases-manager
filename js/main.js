
"use strict"


$(document).ready(function(){

  // CONTENT VIEW TYPE
  var content_view = 1; // 1 = Tabs View & 2 = Vertical View

  // LOAD TIMING FOR LOADERS
  const loadTiming = { "StraightLoader_Timing": 1200 }

  // CONNECTION TO DATABASE BUTTON CLICK
  $(document).on("click", "#connection-btn", function(){

    // CONNECTION TO DATABASE REQUEST
    ajax(
      "modules/handler.php",
      "POST",
      {
        type: "signIn",
        user: $("#username").val(),
        pass: $("#pass").val()
      },
      "JSON",
      function(data){
        if( data == true ){
          $.post("views/home.php", function(data){ $("#ajx-page").empty().html(data).hide().fadeIn("500") })
        }
        else{
          $(".login-container").css({
            "user-select": "initial",
            "opacity": "1"
          })
          $(".login-container input, .login-container select").css("pointer-events", "initial")
        }
      },
      function(){
        RoundedLoader("hide")
      },
      function(){
        RoundedLoader("show", loadTiming.RoundedLoader_Timing, "connection to database...")
        $(".login-container").css({
          "user-select": "none",
          "opacity": ".4"
        })
        $(".login-container input, .login-container select").css("pointer-events", "none")
      }
    )

  });

  // TABLE ITEM CLICK
  $(document).on("click", ".table-item", function(){
    $(".table-item").each(function(){ $(this).removeClass("selected") })
    $(this).closest(".table-item").addClass("selected")

    // GET TABLE DATA & STRUCTURE
    ajax(
      "views/tableDataTabsView.php",
      "GET",
      'database='+$(this).data("db")+"&table="+$(this).data("table"),
      "HTML",
      function(data){
        $("#ajx-content").empty().html(data)
        StraightLoader("show")
      },
      function() {
        StraightLoader("hide", loadTiming.StraightLoader_Timing)

        var cols = null;
        const databaseName = $(".table-item.selected").data("db")
        const tableName = $(".table-item.selected").data("table")


        // BRAHIM DataTable
        $.ajax ({
          url: "modules/handler.php",
          type: "POST",
          data: {
            type: "table",
            database: databaseName,
            table: tableName
          },
          dataType: "JSON",
          async: false,
          success: function(data){
            console.log(data.rows);
            console.log(dataTableColumns (columns(data.rows))); // shuf function li 3mleti kat3ti error
          }
        })

        // $('#table-data').dataTable({
        //   destroy: true,
        //   "pagingType": "simple_numbers",
        //   "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
        //   ajax: {
        //     url: "modules/handler.php",
        //     type: "POST",
        //     data: {
        //       type: "table",
        //       database: databaseName,
        //       table: tableName
        //     },
        //     async: false,
        //     dataType: "JSON",
        //     dataSrc: function(json){
        //       dataTableColumns(json);
        //     }
        //   },
        //   columns: cols
        // })


      }
    );

    //tableStructure_Initialize()
    if( content_view == 1 ) $("#table-structure_wrapper").hide(0)
  })

  // CHANGE VIEW BUTTON CLICK
  $(document).on("click", "#change-view-btn", function(){
    const $this = $(this)
    if( content_view === 1 ){
      content_view = 2
      ajax(
        "views/tableDataVerticalView.php",
        "GET",
        null,
        "HTML",
        function(data){
          $("#ajx-content").html(data).hide().fadeIn(600)
        },
        function(){
          tableStructure_Initialize()
          tableData_Initialize()
        }
      )
    }else{
      content_view = 1
      ajax(
        "views/tableDataTabsView.php",
        "GET",
        null,
        "HTML",
        function(data){
          $("#ajx-content").html(data).hide().fadeIn(600)
        },
        function(){
          tableStructure_Initialize()
          tableData_Initialize()
        }
      )
    }
  });

  // GET ALL DATABASES NAMES
  (function () {
    // brahim => hnaya ajax li katjib databases names
    // => component haw 3andk exemple dyalu f => home.php => sidebar section
    ajax("modules/handler.php", "post", { type: "databases" }, "JSON", function (data) {
      alert(data)
    });
  }());

  // DATABASE ITEM CLICK
  $(document).on("click", ".database-item", function () {
    // Retrieve clicked database
    var databaseName = $(this).data("db");

    ajax ("modules/handler.php", "POST", {type:'tables', database: databaseName}, "JSON", function (data){
      console.log ("database table names");
      console.log (data);
    });
  })

  // TABLE ITEM CLICK
  $(document).on("click", ".table-item", function () {
    // Retrieve selected table
    var databaseName = $(".table-item.selected").data("db");
    var tableName = $(".table-item.selected").data("table");

    ajax ("modules/handler.php", "post", {
      type:'table',
      database: databaseName,
      table: tableName
    }, "JSON", function (data){
      alert (data.rows)
    });
  })

})

// STRAIGHT LOADER
function StraightLoader(action, loadTiming = null){
  $(".section-container").css({
    opacity: ".2",
    "user-select": "none"
  })
  if( action === "hide" ){
    setTimeout(function(){
      $(".loader-straight").hide()
        $(".section-container").css({
          opacity: "1",
          "user-select": "initial"
        })
    }, loadTiming)
  }
  if( action === "show" ) $(".loader-straight").show()
}

// ROUNDED LOADER
function RoundedLoader(action, loadTiming, text){
  if( action === "show" ){
    $(".loader-rounded").show()
    $(".loader-rounded .loader-text").text(text)
  }
  if(action === "hide")
    $(".loader-rounded").hide()
}

// DATABALE INITIALIZE (Data)
function tableData_Initialize(){

  // VARIABLES
  var cols = null;
  var rows = null;
  const databaseName = $(".table-item.selected").data("db")
  const tableName = $(".table-item.selected").data("table")

  $.ajax ({
    url: "modules/handler.php",
    type: "POST",
    data: {
      type: "table",
      table: tableName,
      database: databaseName
    },
    dataType: "JSON",
    success: function(data){
      cols = data['columns']
      console.log(cols);
    }
  })

  $('#table-data').DataTable({
    destroy: true,
    "pagingType": "simple_numbers",
    "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
    ajax: {
      url: "modules/handler.php",
      type: "POST",
      data: {
        type: "table",
        table: tableName,
        database: databaseName
      },
      dataType: "JSON"
    },
    columns: cols
  })
}

// DATABALE INITIALIZE (Structure)
function tableStructure_Initialize(){

  // VARIABLES
  var cols = null;
  const databaseName = $(".table-item.selected").data("db")
  const tableName = $(".table-item.selected").data("table")

  // GET DATATABLE COLUMNS
  $.ajax ({
    url: "../includes/getTableData.php",
    type: "POST",
    data: {
      database: databaseName,
      table: tableName
    },
    dataType: "JSON",
    success: function(data){
      cols = data['columns']
    }
  })

  // DATABALE INITIALIZE (Data)
  $('#table-structure').dataTable({
    destroy: true,
    "pagingType": "simple_numbers",
    "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
    ajax: {
      url: "../includes/getTableData.php",
      type: "POST",
      data: {
        database: databaseName,
        table: tableName
      },
      dataType: "JSON"
    },
    columns: cols
  })

}
