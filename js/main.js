
"use strict"

// LOAD TIMING FOR LOADERS
const loadTiming = { "StraightLoader_Timing": 1200 }

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
        tableData_Initialize()
        tableStructure_Initialize()
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

  // GET ALL DATABASES NAMES


  // DATABASE ITEM CLICK
  // brahim => hnaya ajax li katjib tables [ name, rowsCount, size ]
  // => component haw 3andk exemple dyalu f => home.php => sidebar section
  $(document).on("click", ".database-item", function(){
  })

})

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
      StraightLoader("hide", loadTiming.StraightLoader_Timing)

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
      StraightLoader("hide", loadTiming.StraightLoader_Timing)

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
