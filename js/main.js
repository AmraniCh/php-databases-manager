"use strict"

$(document).ready(function () {

  checkIfConnected();
  //checkMysqlConnStatus ();

  // Global Variables
  var content_view = 1,
    tableName,
    tableRowsCount,
    tableColumns,
    selectedDB,
    selectedTable,
    pkSelectedRow,
    username;

  // Connection To Database Button Click
  $(document).on("click", "#connection-btn", function () {

    // CONNECTION TO DATABASE REQUEST
    ajax("modules/handler.php", "POST", { type: "signIn", user: $("#username").val(), pass: $("#pass").val() }, "JSON", function (data) {
      if (data == true) {
        username = $("#username").val();
        ajax("views/home.php", "GET", null, "HTML", function (data) {
          $("#ajx-page").empty().html(data).hide().fadeIn("500")
        }, function () {
          SidebarLoader("show")
          panelLogsInit();
        })
      }
    }, function () {
      RoundedLoader("hide");
      getAllDatabasesNames();
    }, function () {
      RoundedLoader("show", "connection to MySQL...");
    }
    )

  });

  // Navigation Table Item CLick
  $(document).on("click", ".table-item", function () {
    const $this = $(this);

    closeAllModals();

    selectedTable = $this.data("table");

    $(".table-item").each(function () { $(this).removeClass("selected") })
    $(this).closest(".table-item").addClass("selected")

    // GET TABLE DATA & STRUCTURE VIEW
    ajax("views/tableDataTabsView.php", "GET", 'database=' + $(this).data("db") + "&table=" + $(this).data("table"), "HTML", function (data) {
      $("#ajx-content").empty().html(data)
      tableName = $this.data("table")
      tableRowsCount = $this.find(".table-count").text()
    }, function () {
      $("#table-name").text(tableName)
      $("#table-rows").text(tableRowsCount)
      tableData_Initialize()
      tableStructure_Initialize()
      panelLogsInit();
    }
    );

  });

  // Change View Type Button
  $(document).on("click", "#change-view-btn", function () {
    const $this = $(this)
    if (content_view === 1) {
      content_view = 2
      ajax(
        "views/tableDataVerticalView.php",
        "GET",
        null,
        "HTML",
        function (data) {
          $("#ajx-content").html(data).hide().fadeIn(600)
          tableData_Initialize()
          tableStructure_Initialize()
        }, function () {
          $("#table-name").text(tableName)
          $("#table-rows").text(tableRowsCount)
        }
      );
    } else {
      content_view = 1
      ajax("views/tableDataTabsView.php", "GET", null, "HTML", function (data) {
        $("#ajx-content").html(data).hide().fadeIn(600)
        tableData_Initialize()
        tableStructure_Initialize()
      }, function () {
        $("#table-name").text(tableName)
        $("#table-rows").text(tableRowsCount)
      }
      )
    }
  });

  // Navigation Database Item CLick
  $(document).on("click", ".database-item", function () {
    const $this = $(this);

    if ($this.attr("data-toggle") == "close") {

      selectedDB = $(this).data("db");

      ajax("modules/handler.php", "POST", { type: 'tables', database: selectedDB }, "JSON", function (json) {

        $this.closest(".database-toggle").children(".database-table-items").html("")

        $.each(json, function (index) {

          $this.closest(".database-toggle").children(".database-table-items").append(`<div class="table-item panel-item light-blue" data-table="${json[index].name}" data-db="${selectedDB}">
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

      }, function () {
        $(".loader-table").hide()
      }, function () {
        $this.closest(".database-toggle").children(".database-table-items").html(`<div class="loader-table hide"></div>`);
        $(".loader-table").show();
      });

    }

  });

  // Settings Menu Permissions View item click
  $(document).on("click", "#permissions-page", function () {

    ajax("views/permissions.php", "GET", null, "HTML", function (data) {

      $("#ajx-permissions").html(data)

      ajax("modules/handler.php", "post", { type: "users" }, "JSON", function (json) {

        $.each(json, function (index, element) {
          const dbName = json[index].name;

          $(".sidebar-databases-items").append(`<div class="database-toggle">
            <div class="user-item panel-item blue" data-toggle="close" data-user="${dbName}">
              <ul class="list-unstyled list-inline float-lt">
                <li>
                  <button type="button" class="btn">
                    <i class="icon-big mdi mdi-account"></i>
                  </button>
                </li>
                <li>${dbName}</li>
              </ul>
              <button type="button" class="btn float-rt hide" data-value="close">
                <i class="icon-big mdi mdi-arrow-down-drop-circle"></i>
              </button>
              <button type="button" class="btn float-rt hide" data-value="open">
                <i class="icon-big mdi mdi-arrow-up-drop-circle"></i>
              </button>
              <div class="clearfix"></div>
            </div>
            </div>`);
        })

      }, function () {
        SidebarLoader("hide")
      }, function () {
        SidebarLoader("show")
      });

    }, function () {

      tablePermissions_Initialize();

    });

  });

  // Table => Edit Button click
  $(document).on("click", "#modal-edit-btn", function () {
    $(".modal-edit-overlay").show();
    $(".modal-edit-insert").hide().fadeIn();

    // pass row data to modal inputs
    var tds = $(this).closest("tr").children("td");
    var rowData = [];
    $.each(tds, function () { rowData.push($(this).data("value")) });

    $(".modal-edit-insert .modal-section").html("");
    $.each(tableColumns, function (index) {

      const disabled = (index == 0) ? `disabled="true"` : ``;

      $(".modal-edit-insert .modal-section").append(`<div class="input-group">
        <label for="">${tableColumns[index].name}</label>
        <input type="text" class="input" ${disabled} value="${rowData[index]}">
      </div>`);
    });

  });

  // Edit Modal => save button
  $(document).on("click", "#save-btn", function () {

    var tableRow = []; // get inptus values
    $(".modal-edit-overlay input").each(function () {
      tableRow.push($(this).val())
    });

    // bind update data object
    var data = {};
    data['type'] = 'update';
    data['database'] = selectedDB;
    data['table'] = selectedTable;

    var pkColumnName, pkColumnData; // primary key => last item

    $.each(tableRow, function (index) {
      if (index === 0) {
        pkColumnName = tableColumns[index].name;
        pkColumnData = tableRow[index];
      } else {
        data[tableColumns[index].name] = tableRow[index];
      }
    });

    data[pkColumnName] = pkColumnData;

    ajax("modules/handler.php", "POST", data, "JSON", null, function () {
      $(".modal-edit-overlay").hide();
      $(".table-item.selected").click();
    });

  });

  // Table => Delete Button click
  $(document).on("click", "#modal-delete-btn", function () {
    $(".modal-delete-overlay").fadeIn()
    pkSelectedRow = $(this).closest("tr").children("td:first").data("value");
  });

  // Add Modal => add row button
  $(document).on("click", "#modal-add", function () {
    $(".modal-add-overlay").show(0);
    $(".modal-edit-insert").hide().fadeIn();

    $(".modal-edit-insert .modal-section").html("");
    $.each(tableColumns, function (index) {
      $(".modal-edit-insert .modal-section").append(`<div class="input-group">
        <label for="">${tableColumns[index].name}</label>
        <input type="text" class="input" value="">
      </div>`);
    });
  });

  // Show Add Modal
  $(document).on("click", "#add-row", function () {

    // bind update data object
    var data = {};
    data['type'] = 'insert';
    data['database'] = selectedDB;
    data['table'] = selectedTable;

    $.each($(".modal-add-overlay input"), function (index) { data[tableColumns[index].name] = $(this).val() });

    ajax("modules/handler.php", "POST", data, "JSON", null, function () {
      $(".modal-add-overlay").hide();
      $(".table-item.selected").click();
    });


  });

  // MODAL DELETE - DELETE BUTTON
  $(document).on("click", "#delete-row", function () {

    // bind ajax data param
    var data = {};
    data['type'] = "delete";
    data['database'] = selectedDB;
    data['table'] = selectedTable;
    data[tableColumns[0].name] = pkSelectedRow;

    var col = tableColumns[0].name;
    ajax("modules/handler.php", "POST", data, "JSON", function (json) {
      if (json == true) {
        $(".modal-delete-overlay").hide();
        $(".table-item.selected").click();
      }
    }, function () {
      $(".modal-delete").css({ "pointer-events": "all", "opacity": "1" })
    }, function () {
      $(".modal-delete").css({ "pointer-events": "none", "opacity": ".8" })
    }
    );

  });

  // Settings Menu logout item click
  $(document).on("click", "#logout-btn", function () {
    ajax("modules/handler.php", "POST", { type: "signOut" });
    ajax("views/login.html", "GET", {}, "HTML", function (data) {
      $("#ajx-page").html(data).hide(0).fadeIn(800)
    });
  });

  // Datatable Initiliaze
  function tableData_Initialize() {

    // VARIABLES
    const databaseName = $(".table-item.selected").data("db")
    const tableName = $(".table-item.selected").data("table")

    $.ajax({
      url: "modules/handler.php",
      type: "POST",
      data: {
        type: "table",
        table: tableName,
        database: databaseName
      },
      dataType: "JSON",
      beforeSend: function () {
        StraightLoader("show")
      },
      success: function (json) {
        StraightLoader("hide")

        tableColumns = json.columns;

        if (!jQuery.isEmptyObject(json.rows)) {
          var cols = columns(addControlButtons(json.rows));

          $("#table-data thead, #table-data tbody").children().empty();
          cols.forEach(e => $("#table-data thead").append("<th>" + e + "</th>"));

          $("#table-data").DataTable({
            destroy: false,
            data: addControlButtons(json.rows),
            columns: dataTableColumns(cols),
            createdRow: function (row, data, index) {
              var tds = $(row).children("td");
              for (var i = 0; i < tds.length; i++) {
                tds[i].setAttribute("data-column", cols[i]);
                tds[i].setAttribute("data-value", data[cols[i]]);
              }
            }
          });
        } else {
          $("#table-data thead").children().empty();
          tableColumns.forEach(e => $("#table-data thead").append("<th>" + e.name + "</th>"));
        }

      }
    })

  }

  // Datatable Initiliaze
  function tableStructure_Initialize() {

    // VARIABLES
    const databaseName = $(".table-item.selected").data("db")
    const tableName = $(".table-item.selected").data("table")

    $.ajax({
      url: "modules/handler.php",
      type: "POST",
      data: {
        type: "table",
        table: tableName,
        database: databaseName
      },
      dataType: "JSON",
      beforeSend: function () {
        StraightLoader("show")
      },
      success: function (json) {
        StraightLoader("hide")

        var cols = columns(json.columns);

        $("#table-structure thead").children().empty();
        cols.forEach(e => $("#table-structure thead").append("<th>" + e + "</th>"));

        $("#table-structure").DataTable({
          destroy: false,
          data: json.columns,
          columns: dataTableColumns(columns(json.columns))
        });
      }
    });

  }

  // Datatable Initialize 
  function tablePermissions_Initialize() {

    // VARIABLES
    const selectedUser = $(".user-item.selected").data("user");

    /*
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
    }); */

    $('#table-permissions').DataTable();

  }

  // Get All Databases
  function getAllDatabasesNames() {

    ajax("modules/handler.php", "post", { type: "databases" }, "JSON", function (json) {

      $("#db-count").text(json.count)

      $.each(json.databases, function (index) {

        const dbName = json.databases[index].name;
        const dbCount = json.databases[index].count;

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
      });

    }, function () {
      SidebarLoader("hide")
    }, function () {
      SidebarLoader("show")
    });

  }

  // Logs Panel Updating
  function panelLogsInit() {

    const sldTable = $(".table-item.selected").length;

    if (!sldTable) { // if no table selected

      $(".logs-panel").removeClass("active");

    } else { // if table selected

      $("#logs-tableName").text($(".table-item.selected").attr("data-table"));

      $(".logs-panel").addClass("active");

      ajax("modules/handler.php", "POST", {
        type: 'logs',
        database: selectedDB,
        table: selectedTable
      }, "JSON", function (json) {

        $("#logs-countLogs").text(json.length);

        $(".panel-content").empty();

        $.each(json, function (index) {

          const logExpression = [];
          logExpression["insert"] = "has inserted a new record table";
          logExpression["delete"] = "has deleted the row where ";
          logExpression["update"] = "has updated the row where ";

          const logComponent = `<div class="log-item" data-type="${json[index].event}">
            <span class="badge"></span>
            <div class="log-item-content">
              <div class="content float-lt">
                <span class="bold">"${username}" ${logExpression[json[index].event]} ${tableColumns[0].name} = ${json[index].id} </span>
              </div>
              <div class="time float-rt">
                <i class="mdi mdi-clock"></i>
                <span class="text-color"> ${json[index].time}</span>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>`;

          $(".panel-content").append(logComponent);

        });

      });

    }

  }

  // check if connected to datatabase
  function checkIfConnected() {

    ajax("modules/handler.php", "post", { type: "checkIfConnected" }, "JSON", function (json) {

      if (json == true) {
        username = $("#username").val();
        ajax("views/home.php", "GET", {}, "HTML", function (data) {
          $("#ajx-page").html(data)
        }, function () {
          getAllDatabasesNames();
        });

      }

    }, function () {

      RoundedLoader("hide");

    }, function () {

      RoundedLoader("show", "Check if Connected To Mysql Server ...")

    });

  }

  // check mysql status
  function checkMysqlConnStatus() {

    setInterval(function () {

      ajax("modules/handler.php", "POST", { type: "status" }, "JSON", function (json) {

      })

    }, 4000);

  }

  // close all modals
  function closeAllModals() { $(".modal-edit-overlay, .modal-add-overlay, .modal-delete-overlay").hide() }

});
