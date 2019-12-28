
"use strict"

// CONTENT VIEW TYPE
var content_view = 1; // 1 = Tabs View & 2 = Vertical View

$(document).ready(function(){

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
          $.post("views/home.php", function(data){
            $("#ajx-page").empty().html(data).hide().fadeIn("500")
            // NO SELECTED HEADING ADJUST HEIGHT
            const contentHeight = $(".section-container").height() / 2
            $(".no-selected").css("padding-top", contentHeight - 50)
          })
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
        getAllDatabasesNames()
      },
      function(){
        RoundedLoader("show", "connection to database...")
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

    const $this = $(this);
    var tableName = null;
    var tableRowsCount = 0;

    // GET TABLE DATA & STRUCTURE
    ajax( "views/tableDataTabsView.php", "GET", 'database='+$(this).data("db")+"&table="+$(this).data("table"), "HTML", function(data){
        $("#ajx-content").empty().html(data)
        tableName = $this.data("db")
        tableRowsCount = $this.find(".table-count").text()
        tableData_Initialize()
        tableStructure_Initialize()
      }, function(){
        $("#table-name").text(tableName)
        $("#table-rows").text(tableRowsCount)
      }
    );
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
          tableData_Initialize()
          tableStructure_Initialize()
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
          tableData_Initialize()
          tableStructure_Initialize()
        }
      )
    }

  });

  // DATABASE ITEM CLICK
  $(document).on("click", ".database-item", function () {
    // Retrieve clicked database
    const databaseName = $(this).data("db");

    const $this = $(this);

    ajax ("modules/handler.php", "POST", {type:'tables', database: databaseName}, "JSON", function (json){

      $.each(json, function(index){

        $this.closest(".database-toggle").children(".database-table-items").append(`<div class="table-item panel-item light-blue" data-table="${json[index].name}" data-db="${databaseName}">
            <ul class="list-unstyled list-inline float-lt">
              <li>
                <button type="button" class="btn">
                  <i class="icon-big mdi mdi-table"></i>
                </button>
              </li>
              <li>${json[index].name} (<span class="table-count">${json[index].count}</span>)</li>
            </ul>
            <div class="table-size float-rt">${json[index].size} KIB</div>
            <div class="clearfix"></div>
          </div>`);
      })

    });



  })

  // PERSMISSIONS PAGE MENU BUTTON CLICK
  $(document).on("click", "#permissions-page", function(){

  });

});

// STRAIGHT LOADER
function StraightLoader(action){
  if( action === "hide" ){
      $(".loader-straight").hide()
        $(".section-container").css({
          opacity: "1",
          "user-select": "initial"
        })
  }
  if( action === "show" ){
     $(".loader-straight").show()
     $(".section-container").css({
       opacity: ".2",
       "user-select": "none"
     })
   }
}

// ROUNDED LOADER
function RoundedLoader(action, text){
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
    beforeSend: function(){
      StraightLoader("show")
    },
    success: function(json){
      StraightLoader("hide")

      var cols = columns (json.rows);

      $("#table-data thead").children ().empty ();
      cols.forEach (e => $("#table-data thead").append ("<th>" + e + "</th>"));

      $("#table-data").DataTable ({
          destroy: false,
          data: json.rows,
          columns: dataTableColumns (cols)
      });

    }
  })

}

// DATABALE INITIALIZE (Structure)
function tableStructure_Initialize(){

  // VARIABLES
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
    beforeSend: function(){
      StraightLoader("show")
    },
    success: function(json){
      StraightLoader("hide")

      var cols = columns (json.columns);

      $("#table-structure thead").children ().empty ();
      cols.forEach (e => $("#table-structure thead").append ("<th>" + e + "</th>"));

      $("#table-structure").DataTable ({
          destroy: false,
          data: json.columns,
          columns: dataTableColumns ( columns (json.columns) )
      });
    }
  });

}

// GET ALL DATABASES NAMES
function getAllDatabasesNames(){

  ajax("modules/handler.php", "post", { type: "databases" }, "JSON", function (json) {

    $.each(json, function(index, element){
      const dbName = json[index].name;
      const dbCount = json[index].count;
      $(".sidebar-databases-items").append(`<div class="database-toggle">
        <div class="database-item panel-item blue" data-toggle="close" data-db="${dbName}">
          <ul class="list-unstyled list-inline float-lt">
            <li>
              <button type="button" class="btn">
                <i class="icon-big mdi mdi-database"></i>
              </button>
            </li>
            <li>${dbName} (${dbCount})</li>
          </ul>
          <button type="button" class="btn float-rt hide" data-value="close">
            <i class="icon-big mdi mdi-arrow-down-drop-circle"></i>
          </button>
          <button type="button" class="btn float-rt hide" data-value="open">
            <i class="icon-big mdi mdi-arrow-up-drop-circle"></i>
          </button>
          <div class="clearfix"></div>
        </div>
        <div class="database-table-items hide">
        </div>
        </div>`);
    })

  });

}
