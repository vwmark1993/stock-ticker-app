/**
 * COMP 10065 - Assignment 5
 * 
 * Author: Vincent Mark, 000803494
 * Date Created: July 26, 2020
 * Description: Handles the AJAX requests of the webpage.
 */

/**
 * Document ready event handler.
 * Initializes the program on load.
 */
$(document).ready(function() {
    /**
     * Retrieves a JSON array of stock records and converts it into a HTML table row to be displayed on the webpage.
     * 
     * @param stocks - A JSON array of stock records
     */
    function displayStocks(stocks) {
        let stockList = ""; // Output string.

        // Stock records are parsed into HTML table data.
        for (let i = 0; i < stocks.length; i++) {
            stockList += 
            "<tr><td>" + stocks[i].stockId + "</td>" +
                "<td>" + stocks[i].stockName + "</td>" +
                "<td>" + stocks[i].price + "</td>" +
                "<td>" + stocks[i].lastUpdated + 
            "</td></tr>";
        }

        // Stocks are displayed in the table.
        $("#stock-table-records").html(stockList);
    }

    /**
     * Retrieves the list of stock records from the database via GET request.
     * This function is called once on program initialization, 
     * and again repeatedly on every 10 seconds and on certain events.
     */
    function getStocks() {

        let length = $(".selected").val(); // Retrieves the number of stock records the user wishes to view.
        let url = "getStock.php?length=" + length; // Attaches the value as a GET request parameter.

        // Fetches and retrieves the list of stock records in JSON format.
        // Sends the JSON array of stock records to displayStocks().
        fetch(url, {credentials: "include"})
            .then(response => response.json())
            .then(displayStocks);
    }

    /**
     * Success function for adding stock records to the database.
     * Notifies the user of the stock records which were added.
     * 
     * @param stockRecordNumbers - A JSON array containing the validated user-inputted stock records.
     */
    function addStockSuccess(stockRecordNumbers) {
        // Clear all form input fields.
        $("#add-stock-form").trigger("reset");
        
        let message = ""; // Output string.
        // The JSON data is parsed into a readable format.
        for (let i = 0; i < stockRecordNumbers.length; i++) {
            message += "Stock Record[" + stockRecordNumbers[i] + "] has been successfully added to the database.<br>"
        }
        // If no valid stock records were entered, notify the user.
        if (stockRecordNumbers.length === 0) {
            message += "Invalid stock record values were submitted. Please try again.";
        }
        // Notification is displayed back to the user.
        $("#add-stock-message").html(message);
    }

    /**
     * Event handler for the display size of the stock record feed.
     * Changes the size of the stock record feed based on the selected option.
     * Refreshes the stock record feed.
     */
    function stockFeedLengthHandler() {
        $("#stock-table-length").children().removeClass("selected");
        $(this).addClass("selected");

        getStocks(); // Refreshes the stock record feed each time the user changes the display size.
    }

    /**
     * Event handler for toggling between the 'Add Stock' and 'View Stock' menus.
     */
    function toggleButtonHandler() {
        if ($("#stock-table:visible").length) {
            $(".get-stock-container").hide("slow",
                $(".add-stock-container").show()
            );
            $("#toggle-button").html("View Stock");
        } else {
            $(".add-stock-container").hide("slow",
                $(".get-stock-container").show()
            );
            $("#toggle-button").html("Add Stock");
        }
        $("#add-stock-message").empty();
    }

    /**
     * Retrieves the list of stock records the user wishes to upload.
     * Parses the data and sends a POST request to 'addStock.php'.
     */
    function addStockHandler() {
        // Disables the form from submitting, allowing the AJAX code below to handle the HTTP request instead.
        event.preventDefault();

        let url = "addStock.php"; // Target destination.

        // Parameter values are retrieved.
        let stockId1 = document.forms.addStockForm.stockId1.value;
        let stockName1 = document.forms.addStockForm.stockName1.value;
        let stockPrice1 = document.forms.addStockForm.stockPrice1.value;

        let stockId2 = document.forms.addStockForm.stockId2.value;
        let stockName2 = document.forms.addStockForm.stockName2.value;
        let stockPrice2 = document.forms.addStockForm.stockPrice2.value;

        let stockId3 = document.forms.addStockForm.stockId3.value;
        let stockName3 = document.forms.addStockForm.stockName3.value;
        let stockPrice3 = document.forms.addStockForm.stockPrice3.value;

        let stockId4 = document.forms.addStockForm.stockId4.value;
        let stockName4 = document.forms.addStockForm.stockName4.value;
        let stockPrice4 = document.forms.addStockForm.stockPrice4.value;
        
        // Values are parsed into POST request parameters.
        let params = "stockId1=" + stockId1 + "&stockName1=" + stockName1 + "&stockPrice1=" + stockPrice1 +
            "&stockId2=" + stockId2 + "&stockName2=" + stockName2 + "&stockPrice2=" + stockPrice2 +
            "&stockId3=" + stockId3 + "&stockName3=" + stockName3 + "&stockPrice3=" + stockPrice3 +
            "&stockId4=" + stockId4 + "&stockName4=" + stockName4 + "&stockPrice4=" + stockPrice4;

        // Sends the parameters to 'addStudent.php' as a POST request.
        fetch(url, {
            method: "POST",
            credentials: "include",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: params
        })
        .then(response => response.json())
        .then(addStockSuccess);
    }

    // Event listeners are set.
    $("#toggle-button").on("click", toggleButtonHandler);
    $("#stock-table-length").children().on("click", stockFeedLengthHandler);
    $("#add-stock-form").on("submit", addStockHandler);

    // The list of recent stocks is retrieved and displayed on program initialization.
    getStocks();
    // The stock feed is updated again every 10 seconds.
    setInterval(getStocks, 10000);
});