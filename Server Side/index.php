<?php
    session_start();


?>
<html>

<head>
    <title> Center Activities </title>
    <meta charset="utf-8" />
	
	<link href="test.css"
          type="text/css" rel="stylesheet" />
		  
	<script src ="searchfunct.js" type="text/javascript"></script>
	

    <?php
        /* Here we add every new page we create (Linking every page together) */
        define("domain", "http://nrs-projects.humboldt.edu/~Alt-F4");
				require_once('hsu_conn_sess.php');
                require_once('Login.php');
				require_once('MainMenu.php'); //added the require for main menu back up here because as long everything is in the
				                              //php function nothing unwanted html will show on the correct page
                require_once('/home/Alt-F4/public_html/VendorSection/MainVendor.php');  //Since the files are under a subdirectory, the require_once
				                                                                         //statement have to look like this
				require_once('/home/Alt-F4/public_html/VendorSection/AddVendor.php');
				require_once('/home/Alt-F4/public_html/VendorSection/EditVendor.php');
				require_once('/home/Alt-F4/public_html/VendorSection/VendorInfo.php');
				require_once('/home/Alt-F4/public_html/VendorSection/addvendor-posthandler.php');
				require_once('/home/Alt-F4/public_html/ItemreturnSection/ReturnItem_main.php');
				require_once('/home/Alt-F4/public_html/ItemreturnSection/Receipt.php');
				require_once('/home/Alt-F4/public_html/ItemreturnSection/complain_and_exit.php');
				require_once('/home/Alt-F4/public_html/ItemreturnSection/destroy_and_exit.php');
				require_once('/home/Alt-F4/public_html/ItemreturnSection/build_mini_form.php');
				require_once('/home/Alt-F4/public_html/ItemreturnSection/CustRentedItems.php');
				require_once('/home/Alt-F4/public_html/ItemselectionSection/ItemSelectionMenu.php');
				require_once('/home/Alt-F4/public_html/ItemselectionSection/AddingNewItems.php');
				require_once('/home/Alt-F4/public_html/ItemselectionSection/ItemInfo.php');
				require_once('/home/Alt-F4/public_html/ItemselectionSection/EditItem.php');
				require_once('/home/Alt-F4/public_html/CustomerselectionSection/CustomerSelectionMain.php');
				require_once('/home/Alt-F4/public_html/CustomerselectionSection/CustomerInfor.php');
				require_once('/home/Alt-F4/public_html/CustomerselectionSection/CustomerTransaction.php');
				require_once('/home/Alt-F4/public_html/CustomerselectionSection/EditCustomer.php');
				require_once('/home/Alt-F4/public_html/RentalSection/RentalStartingPage.php');
				require_once('/home/Alt-F4/public_html/RentalSection/NewCustomer.php');
				require_once('/home/Alt-F4/public_html/RentalSection/RentalItemSelection.php');
				require_once('/home/Alt-F4/public_html/RentalSection/CalculatePayments.php');

    ?>
 

</head>
<body>
    <?php

	if (! array_key_exists('next_page', $_SESSION))       //Here when we first enter the site and check the if there is a session or at all.
    {
        login();     //We call the Login function which allows users login
		$_SESSION['next_page'] = "MainMenu"; //We set the session key 'next_page' equal the spring value 'MainMenu'
    }
	elseif($_SESSION['next_page'] == "MainMenu")
	{
		$username = strip_tags($_POST['username']);  //We grab the username and password the user input and logs the user in with the inputs
		$password = strip_tags($_POST['password']);
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		$conn = hsu_conn_sess($username, $password);
		//Here we call the function 'hsu_conn_sess' which will does the connection to nrs-projects
	    mainmenu();
		$_SESSION['next_page'] = "mainmenu_buttons";
		//var_dump ($_SESSION);
		//The user wouldn't go back to this elseif ever again, none less they press the logout button.
	}


	//======================================================================
	//Main Menu Section
	//======================================================================

	elseif($_SESSION['next_page'] == "mainmenu_buttons")  //Now we're getting into the functional of all the buttons that are on the main menu
	                                                      //(Pretty much what pages the buttons leads to)
	{
		if(isset($_POST["LogOut"])) //LogOut Button. When pressed logs the user out and set the next_page back to mainmenu
		{
			login();
            $_SESSION['next_page'] = "MainMenu";
		}
		elseif(isset($_POST["ViewVen"])) //View/Edit Vendors Button. Send users to the vendor's section where they can add/view/edit vendors
		{
			Vendor();
            $_SESSION['next_page'] = "Vendor_buttons";
            //var_dump ($_SESSION);
		}
		elseif(isset($_POST["Rental"])) //Rental Button. Send users to the rental's section(for rental).
		{
			Rental();
            $_SESSION['next_page'] = "Rental_buttons";
            //var_dump ($_SESSION);
		}
		elseif(isset($_POST["ViewCus"])) //View/Edit Customer Button. Send users to the customer's section where they can add/view/edit customer
		{
			CustomerSelection();
            $_SESSION['next_page'] = "CustomerSelection_buttons";
            //var_dump ($_SESSION);
		}
		elseif(isset($_POST['ReturnI'])) //ReturnItem Button. Sends users to the Return Item section where users can return/view items
		                                 //that are rented out under their name.
		{
			ReturnItem();
			$_SESSION['next_page'] = "ReturnItem_buttons";
			//var_dump ($_SESSION);
		}
		elseif(isset($_POST['ViewInv'])) //ReturnItem Button. Sends users to the Return Item section where users can return/view items
		                                 //that are rented out under their name.
		{
			Itemselection();
			$_SESSION['next_page'] = "ItemSelection_buttons";
			//var_dump ($_SESSION);
		}
		else  //A "catch all" thing where if there was ever a time a button has not been press and the page somehow moves on,
		      //We just move on back the main section page
		{
			mainmenu();
		}
	}


	//======================================================================
	//Vendor Section
	//======================================================================

	elseif($_SESSION['next_page'] == "Vendor_buttons") //When all the functional of all the vendor's button is going to be placed
	{
		if(isset($_POST["AVendor"])) //AddVendor button on the Vendor main menu. Pushes users to the add venders page.
	    {
		    AddVendor();
	    }
		elseif(isset($_POST["mainmenu"])) //MainMenu button. Allows users to go back to the main menu.
	    {
		    mainmenu();
		    $_SESSION['next_page'] = "mainmenu_buttons";
	    }
		elseif(isset($_POST["editVen"])) //Edit Vendor button. Pushes users to the section to add/remove/edit Vendors.
	    {
		    EditVendor();
	    }
		elseif(isset($_POST["updateVen"]) or isset($_POST["cancelEdit"]) or isset($_POST["moreIn"])) //Update button/Cancel button on Edit Vendor page/More Infor. Button
		                                                                                             //Pushes users to the More Infor. for Vendors page
	    {
		    InfoVendor();
	    }
		elseif(isset($_POST["removeVen"]) or isset($_POST["backToMainSection"])) //Remove Vendor button on Edit Vendor page/Back button on Vendor's Infor. page.
		                                                                         //Pushes users the Vendor's main menu.
	    {
		    Vendor();
	    }
		else //A "catch all" thing where if there was ever a time a button has not been press and the page somehow moves on,
		     //We just move on back the main section page. We see this mainly when people refresh the page.
		{
			Vendor();
		}
	}


	//======================================================================
	//Item Return Section
	//======================================================================

	elseif($_SESSION['next_page'] == "ReturnItem_buttons")
	{

	    if(isset($_POST["Cancel"]) or isset($_POST["mainmenu"]) or isset($_POST["PrintReceipt"])) //This is ReturnItems CANCEL/MainMenu/PrintReceipt
		                                                                                          //buttons which when press, sends the user back to MainMenu

	   {
		   mainmenu();
	       $_SESSION['next_page'] = "mainmenu_buttons";
		   //var_dump ($_SESSION);
	   }
	   elseif(isset($_POST["Select"]) or isset($_POST["cancelOnReceipt"])) //After finding the customer, the "select" button push the user onto the next page
                                                                        //which is the item check-in page where the user will select which item they are returning today
																		   //Also when the cancel button on the Receipt page is press, the screen will move back to the item check-in
																		   //part of the return section
	   {
        //var_dump ($_SESSION);
		   CustRentedItems();
	   }
	   elseif(isset($_POST["Checkin"])) //Once the user is done selecting the item they are returning today, this button "Checkin" will push the user
	                                    //to the finally page of the item return page which is the Receipt page
	   {
       //var_dump ($_SESSION);
		   Receipt();
	   }
	   else //A "catch all" thing where if there was ever a time a button has not been press and the page somehow moves on,
		     //We just move on back the main section page
			 //Also notice that we didn't add a funtion to the "Back" button. Since the "Back" button has the same functionally
			 //as this, anytime a user press the "Back" the site will think that there wasn't a button pressed and move the screen
			 //back to the main section menu.
		{

			ReturnItem();
		}
	}


	//======================================================================
	//Item Selection Section
	//======================================================================

	elseif($_SESSION['next_page'] == "ItemSelection_buttons") //When all the functional of all the vendor's button is
	                                                          //going to be placed
	{
		if(isset($_POST["mainmenu"])) //This is Itemselection MainMenu
		                              //button which when press, sends the user back to MainMenu
	   {
		   mainmenu();
	       $_SESSION['next_page'] = "mainmenu_buttons";
	   }
	    elseif(isset($_POST["additem"])) //Add Item button on the Item Selection Main Menu page. Pushes users to the add item
		                                 //page
	   {
		    AddItems();
	   }
	   elseif(isset($_POST["updateItem"]) or isset($_POST["cancelEdit"]) or isset($_POST["moreinfo"])) //Update button/Cancel button on Edit Vendor page/More Infor. Button
		                                                                                             //Pushes users to the More Infor. for Vendors page
	    {
		    ItemInfo();
	    }
	   elseif(isset($_POST["editItem"])) //Edit Item button on the Item Infor. page. Pushes users to the editing
		                                 //item page
	   {
		    EditItem();
	   }
	   elseif(isset($_POST["add"]) or isset($_POST["cancel"]) or isset($_POST["backoniteminfo"]) or isset($_POST["removeItem"])) //Add/Cancel buttons on the Adding New Items page.
	                                                                                              //Back button on the item info page, Remove Item button on
																								  //Editing Item page
	                                                                                              //Pushes users to the item selection main menu
	   {
		    Itemselection();
	   }
	   else//A "catch all" thing where if there was ever a time a button has not been press and the page somehow moves on,
         	//We just move on back the main section page
	   {
		   Itemselection();
	   }
    }


	//======================================================================
	//Customer Selection Section
	//======================================================================

	elseif($_SESSION['next_page'] == "CustomerSelection_buttons")
	{
	    if(isset($_POST["mainmenu"])) //This is CustomerSelection/ViewTransaction MainMenu button which when press, sends the user back to MainMenu
	   {
		   mainmenu();
	       $_SESSION['next_page'] = "mainmenu_buttons";
	   }
	   elseif(isset($_POST["select"]) or isset($_POST["backOnCustTran"]) or isset($_POST["cancelOnEditCust"])) //Select button on the main customer/Back button on view transaction
                                                                                                               // Cancel/Update Customer button on the Customer Edit Page
	                                                                                                           // Pushs user to the the Customer's Information Page
	   {
		   CustomerInfo();
	   }
	   elseif(isset($_POST["removeCust"])) //The remove customer button on the edit customer view
	   {
		    $username = $_SESSION['username']; 
			$password = $_SESSION['password'];
			$conn = hsu_conn_sess($username, $password);
			$sel_user = $_SESSION['sel_user']; //Grabbing the customer that was selected
			$delete_cust = "DELETE FROM Customer WHERE cust_id = :sel_user";
			$stmt = oci_parse($conn, $delete_cust);
			oci_bind_by_name($stmt, ":sel_user", $sel_user);
			oci_execute($stmt, OCI_DEFAULT);
            oci_commit($conn);
			CustomerSelection();
			oci_free_statement($stmt);
			oci_close($conn);
	   }
	   elseif(isset($_POST["updateCust"])) //Here for the update button on the edit customer view
			{
				$username = $_SESSION['username']; 
				$password = $_SESSION['password'];
				$conn = hsu_conn_sess($username, $password);
				$sel_user = $_SESSION['sel_user']; //Grabbing the customer that was selected
				$new_f_name = htmlspecialchars(strip_tags($_POST["curr_f_name"])); //Here once the user input any changes on the customer information, we then grab all the newly changes 
				$new_l_name = htmlspecialchars(strip_tags($_POST["curr_l_name"]));
				$new_addr = htmlspecialchars(strip_tags($_POST["curr_addr"]));
				$new_phone = htmlspecialchars(strip_tags($_POST["curr_phone"]));
				$new_email = htmlspecialchars(strip_tags($_POST["curr_email"]));
				$new_dob = htmlspecialchars(strip_tags($_POST["curr_dob"]));
				$new_emg = htmlspecialchars(strip_tags($_POST["curr_emg_contact"]));
				// Set up the update sql command
                $update_sql = "UPDATE Customer
                               SET f_name = :new_f_name,
                                   l_name = :new_l_name,
                                   c_dob = :new_dob,
                                   c_addr = :new_addr,
                                   c_phone= :new_phone,
                                   c_email = :new_email,
                                   emerg_contact = :new_emg 
                                WHERE cust_id = :sel_user";

				$stmt = oci_parse($conn, $update_sql);
				oci_bind_by_name($stmt, ":new_f_name", $new_f_name); //Bind all the newly information 
				oci_bind_by_name($stmt, ":new_l_name", $new_l_name);
				oci_bind_by_name($stmt, ":new_dob", $new_dob);
				oci_bind_by_name($stmt, ":new_addr", $new_addr);
				oci_bind_by_name($stmt, ":new_phone", $new_phone);
				oci_bind_by_name($stmt, ":new_email", $new_email);
				oci_bind_by_name($stmt, ":new_emg", $new_emg);
				oci_bind_by_name($stmt, ":sel_user", $sel_user);

				oci_execute($stmt, OCI_DEFAULT);
                oci_commit($conn);
				CustomerInfo();
				oci_free_statement($stmt);
				oci_close($conn);
           }
	   elseif(isset($_POST["viewTran"]) or isset($_POST["PrintReceipt"]) or isset($_POST["cancelOnReceipt"])) //View Transaction button on Customer Information page
	                                                                                                          //PrintReceipt/Cancel buttons Receipt page.
	                                                                                                          //Pushs users to the View Transaction Page for customers
	   {
		   CustomerTran();
	   }
	    elseif(isset($_POST["viewReceipt"])) //View Receipt button. Pushs users to the receipt for printing purposes.
	   {
		   Receipt();
	   }
	   elseif(isset($_POST["editCust"])) //Edit Customer button. Pushs users to the edit customer page.
	   {
		   EditCustomer();
	   }
	   else //A "catch all" thing where if there was ever a time a button has not been press and the page somehow moves on,
		     //We just move on back the main section page
			 //Also notice that we didn't add a funtion to the "Back" button on the Customer Information Page. Since this "Back" button pushs the user back to
			 //the main section menu, anytime a user press the "Back" the site will think that there wasn't a button pressed and move the screen
			 //back to the main section menu.
		{
			CustomerSelection();
		}
	}


	//======================================================================
	//Rental Section
	//======================================================================

	elseif($_SESSION['next_page'] == "Rental_buttons")
	{
	    if(isset($_POST["mainmenu"]) or isset($_POST["cancel"]) or isset($_POST["cancelOnReceipt"]) or isset($_POST["PrintReceipt"])) //This MainMenu/Cancel/PrintReceipt button
		                                                                                                                              //Send the user back to the MainMenu
		                                                                                                                              //In the whole Rental Section, all cancel buttons pushs the user back to the MainMenu
	   {
		   mainmenu();
	       $_SESSION['next_page'] = "mainmenu_buttons";
	   }
	   elseif(isset($_POST["oldCust"])) //The Old/Existing Customer button. Pushes user to the customer selection page.
	   {
		   CustomerSelection();
	   }
	   elseif(isset($_POST["newCust"])) //The New Customer button. Pushes user to the page where they will enter the customer's information for the creation of the new customer account
	   {
		   AddingNewCust();
	   }
	    elseif(isset($_POST["finalize"])) //Finalize button. Pushs users to the receipt for printing purposes.
	   {
		   Receipt();
	   }
	    elseif(isset($_POST["continue"]) or isset($_POST["select"])) //Continue button on the New Customer page/Select button on the Customer Selection page.
                                                                     //Pushs users to the Rental Item Selectin page.
	   {
		   RentalItemSelect();
	   }
	   elseif(isset($_POST["calPay"])) //Continue to Payments button. Pushs users to the CalculatePayments page.
	   {
		   CalPay();
	   }
	   else //A "catch all" thing where if there was ever a time a button has not been press and the page somehow moves on,
		     //We just move on back the main section page
			 //back to the main section menu.
		{
			Rental();
		}
	}




    // I hope I can't reach this...!

    else
    {

        ?>
        <p> <strong> YIKES! should NOT have been able to reach
            here! </strong> </p>
        <?php

        session_destroy();
        session_regenerate_id(TRUE);
        session_start();

    }
?>
</body>
</html>