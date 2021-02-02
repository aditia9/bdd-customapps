<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tracking Order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <!-- Fonts and icons -->
    
    <style type="text/css">
        /*.medium-up--push-one-tenth{
            left: 0px !important;
            width: 100% !important;
        }*/
        .card{
            opacity: 1 !important;
        }
        .custom .table{
            background: transparent !important;
        }
        .custom .table th,
        .custom .table td{
            padding: 15px;
            white-space: normal !important;
            border-bottom: 1px solid #e5e5e5;
        }
        .custom .table td.titlena{
            font-weight: 600;
        }
        .custom table.pertama tr td:first-child{
            width: 35%;
        }
        .custom table.pertama tr td:last-child{
            width: 60%;
        }
        table.table.pertama{
            margin-bottom: 20px;
        }
        .custom table.kedua tfoot tr:last-child td{
            border-bottom: 0px !important;
        }
        .d-inline-block{
            display: inline-block;
        }
        .card{
            padding: 20px;
            background: white;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
            border: 0;
        }
        .wizcols h4{
            font-size: 18px !important;
        }
        .card-header .title{
            margin-bottom: 30px !important;
        }

        /*modal*/

        .modal {
		  display: none; /* Hidden by default */
		  position: fixed; /* Stay in place */
		  z-index: 1; /* Sit on top */
		  padding-top: 100px; /* Location of the box */
		  left: 0;
		  top: 0;
		  width: 100%; /* Full width */
		  height: 100%; /* Full height */
		  overflow: auto; /* Enable scroll if needed */
		  background-color: rgb(0,0,0); /* Fallback color */
		  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
		}
		.modal-header h2{
			color: white;
		    margin: 10px;
		    font-weight: 600;
		}

		/* Modal Content */
		.modal-content {
		  position: relative;
		  background-color: #fefefe;
		  margin: auto;
		  padding: 0;
		  border: 1px solid #888;
		  width: 50%;
		  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
		  -webkit-animation-name: animatetop;
		  -webkit-animation-duration: 0.4s;
		  animation-name: animatetop;
		  animation-duration: 0.4s
		}

		/* Add Animation */
		@-webkit-keyframes animatetop {
		  from {top:-300px; opacity:0} 
		  to {top:0; opacity:1}
		}

		@keyframes animatetop {
		  from {top:-300px; opacity:0}
		  to {top:0; opacity:1}
		}

		/* The Close Button */
		.close {
		  color: white;
		  float: right;
		  font-size: 28px;
		  font-weight: bold;
		}

		.close:hover,
		.close:focus {
		  color: #000;
		  text-decoration: none;
		  cursor: pointer;
		}

		.modal-header {
		  padding: 2px 16px;
		  background-color: #5cb85c;
		  color: white;
		}

		.modal-body {padding: 2px 16px;}

		.modal-footer {
		  padding: 2px 16px;
		  background-color: #5cb85c;
		  color: white;
		}

        /*endmodal*/

        @media (min-width: 750px){
            .col-sm-3 {
                float: left;
            }
            .row {
                display: flow-root;
            }
            .wizstatedone:after,
            .canceled:after{
                width: 160% !important;
            }
            .row.wizcontainer-fluid{
                display: flex;
                justify-content: center;
            }
        }
        @media (max-width: 749px){
            /*.col-12{
                width: 100%;
            }*/
        }
    </style>
    <!-- CSS Files -->
    <link href="//cdn.shopify.com/s/files/1/0421/7887/1458/t/1/assets/font-awesome.scss.css?v=8545629558324285234" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/custom.css">
    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-font-face.min.css" media="all">
    <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-shims.min.css" media="all">
    <script src="https://kit.fontawesome.com/a94ef6d498.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="custom overlay-sidebar">
        

        <div class="main-panel">
            <div class="content">
                     
                <?php echo $contents ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

    <script>
	// Get the modal
	var modal = document.getElementById("myModal");

	// Get the button that opens the modal
	var btn = document.getElementById("myBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
	  modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
	    modal.style.display = "none";
	  }
	}
	</script>
</body>
</html>