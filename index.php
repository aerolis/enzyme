<?php

include("includes/pg_details.php");
$pg_title = "Home";

//include header block to page
include("includes/header_a.php");

?>

<div class="notice">
 	<p><span style="color:#DAA607; font-weight:bold;">PLEASE NOTE:</span> The GRAPE Server is currently having additional browser dependency problems similar to those described below in the Platform Notes and Known Bugs section. We are currently taking steps to phase out the 		Java viewer in favor of browser-compliant WebGL (HTML5). As such, certain parts of the site (such as Google friend-connect) are being phased out, although they were present in the original documentation and functionality.</p>

<p>If you're interested in being updated on our progress with GRAPE, please enter your e-mail here. Thank you.</p>

<form action="#" method="post">
	<input name="email_address" />
    <button type="submit">Submit</button>
</form>
</div>


<img src="images/GRAPE.jpg" />

<div class="main_body">
<p>The <b>GR</b>aphical <b>A</b>bstracted <b>P</b>rotein <b>E</b>xplorer, <b>GRAPE</b>, is a tool for visualizing macromolecular surfaces and some of the physical and chemical properties on them. Its unique feature is the ability to provide abstracted views of the surface - a new visualization for exploring the surfaces of molecules. The abstractions are computed by the server, and delivered to a 3D viewer that runs in your web browser. You can either provide molecules for the server to abstract, or view previously abstracted molecules (including those submitted by others).</p>

<p>To get started quickly, try picking one of our favorite molecules in the panel to the right, or one of the molecules recommended by other viewers in panel below it.</p>

<h3>What are abstracted surfaces?</h3>

<p>The abstracted surfaces rendered by the GRAPE viewer highlight structural features of a macromolecule by effectively reducing the level of detail. Using a specialized algorithm that preserves large-scale structural features, while removing small bumps and pockets and smoothing scalar fields such as electrostatic potential, users can view a gestalt of their protein surfaces. This entirely new way of looking at proteins complements more traditional views of the solvent-excluded surface. The 3D viewer built into this site will allow you to quickly flip back and forth between both views. In addition to providing a fast way of assessing a molecule's shape, the abstracted views can show a simplified representation of electrostatic and hydropathic surface fields.</p>

<p>See the About This Tool page for more information on how this server works, and who created it. And for even more technical information on how abstractions are constructed, including our IEEE Transactions on Visualization paper, visit our Molecular Abstractions Project Page.</p>

<h3>Collaboration and Discussion</h3>

<p>The purpose of this server is twofold: first, we created it to allow scientists to use our techniques for abstracting protein surfaces on their own molecules. Second, we hope to foster discussion between users both on the molecules themselves and on our techniques for rendering them.</p>

<p>On the right, you can see two Google Friend Connect gadgets. The topmost gadget displays a dynamic list of the proteins most recommended by users of this site. Clicking on any of the names in that box will take you directly to the viewer for that protein. This provides an easy way for both current and new users to quickly find interesting proteins on the site. The bottommost gadget shows a list of the most recent members to use the site.</p>

<p>To recommended proteins yourself, or to comment on any protein, you must first register with Google Friend Connect. Simply click "Join This Site" on the members gadget to get started. Use of the collaboration features is optional.</p>

<h3>Platform Notes and Known Bugs (2010-4)</h3>
<p>This server has been tested thouroughly on Windows XP and 7, using IE 7+, Firefox and Chrome. We have also confirmed that our surface viewer works on OSX 10.5. Please note, however, that three issues have arisen in our testing on the Mac. First, Safari does not currently allow our system to run, due to high cross-site scripting security settings. Second, the Macintosh Java runtime does not properly dispose of OpenGL resources when leaving a page, which can cause memory leaks. If a page seems to have hung, or takes longer than normal to load a protein, please close and restart the browser to fix the issue. Third, Chrome on the Macintosh does not (as of this writing) fully support applets. Therefore, if you're on a Macintosh, you will need to use the Firefox browser, and will probably experience memory leaks from Apple's Java runtime (so you may need to restart your browser after viewing a few molecules).</p>


<h3>Please Cite</h3>
<p>If you use results from the GRAPE Server, please cite:</p>

<p style="padding-left: 20px">    G. Cipriano, G. Wesenberg, T. Grim, G. N. Phillips, Jr., and M. Gleicher
<br />    <b>GRAPE</b>: GRaphical Abstracted Protein Explorer
<br />    Nucleic Acids Research 38, W595-W601, 2010. (doi:10.1093/nar/gkq398)
<br />    (View Abstract)</p>

<h3>Registration</h3>

<p>If you are a first time user, you may wish to register before submitting jobs. This is a separate step from the Friend Connect registration described above, is also completely optional, and does not require disclosing your identity or any personal information. The primary purpose of registering is to give you an easy way to keep a record of and retrieve the results of any abstraction jobs you run. By default, all jobs show up in the public queue, so other users may see them. As a registered user, you also have the option to make any job private, preventing others from seeing it.</p>

<p>If you already have a username, you may use the "Login" button on the menu bar above to use your account.</p>

<p>Please see the GRAPE User’s Manual for information regarding the use of this server.</p> 
</div>

<?php
//include footer block into webpage
include("includes/footer_a.php");
?>
