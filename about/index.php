<?php

include("../includes/pg_details.php");
$pg_title = "About";

//include header block to page
include("../includes/header_a.php");

?>
<div class="notice">
 	<p><span style="color:#DAA607; font-weight:bold;">PLEASE NOTE:</span> The GRAPE Server is currently having additional browser dependency problems similar to those described below in the Platform Notes and Known Bugs section. We are currently taking steps to phase out the 		Java viewer in favor of browser-compliant WebGL (HTML5). As such, certain parts of the site (such as Google friend-connect) are being phased out, although they were present in the original documentation and functionality.</p>

<p>If you're interested in being updated on our progress with GRAPE, please enter your e-mail here. Thank you.</p>

<form action="#" method="post">
	<input name="email_address" />
    <button type="submit">Submit</button>
</form>
</div>


<img src="../images/GRAPE.jpg" />

<div class="main_body">

<h3>About abstraction</h3>

<p>Abstraction transforms the data about a molecule into a simpler form that is more convenient (in this case, for viewing). The process of creating and using an abstraction has three steps: first, we need to obtain the data about a molecule; then we abstract it into a useful form; and then that is loaded into a viewer. With the GRAPE tool, those first two steps happen on the server. The abstracted data (and data about the original molecule) is computed, packaged into a file that is then sent to a relatively lightweight viewing program that is run in the browerser.</p>

<p>The first step of abstraction begins with a PDB file of the requested molecule (either uploaded or fetched from the PDB). The server then compute the "original" or "non-abstracted" data about the molecule using standard tools: it computes the solvent excluded surface using MSMS and the electrostatic potential around the molecule using PDB2PQR and APBS. Other data about the molecule is computed using our own implementations: Hydrophobicity is computed by finding, for each point, the hydropathic index of the closest amino acid in the protein. Our tools predict potential hydrogen bond donor/receptor locations by locating atoms in the sidechains of each amino acid that are both potential donors/receivers, and also near the solvent excluded surface. Our tools also find putative binding sites using our implementation of an algorithm similar to LIGSITE. Finally, points on the surface are denoted as being "ligand contacts" if they are within a radius of 1.6 Angstroms of the van der Waals surface of another part of the molecular assembly (i.e. a different chain in the PDB file), and ambient occlusion lighting is computed. The result of this first step is detailed data about the molecule, which is used to provide a traditional surface view (with ambient occlusion lighting), as well as input to the abstraction process.</p>

<p>The second step of the process performs the abstraction of the data, transforming the detailed results of the first step into a (visually) simpler form. The shape of the molecular surface, as well as the fields on it (e.g. electrostatic potential and hydrophobicity) contain large numbers of small details (i.e. high-frequencies). Though this is an accurate representation of the local character of the surface, this inhibits large scale understanding, the gestalt of the protein. Abstraction smooths over the details.</p>

<p>So as a first step, these fields are smoothed along the surface. This removes small features in the sampled electrostatic potential, while preserving larger areas. Next, the surface itself is put through a series of mesh restructuring operations to first smooth and then 'sand off' small bumps and pockets. The resulting mesh is a very smooth approximation of the original solvent accessible surface, which we call an 'abstracted' surface.</p>

<p>As a final bonus, applying stickers to this abstracted surface is much easier than applying them to the solvent-excluded surface, because of its smoothness. So in this viewer, we show several varieties, including hydrogen bonds, detected pockets, and 'ligand shadows' - areas of the surface that neighbor the surfaces of other chains.</p>

<p>The information that is computed in the first two steps (data preparation and abstraction) is stored in a file that contains the information necessary to draw the traditional and abstracted views of the surface. Because this process can be computationally expensive, the server processes requests for molecules from a queue and stores the results. These results can then be delivered to the viewer program. Note that the viewer program itself receives only information about the surface and the fields on it: it does not get the atomic coordinates, and it does not compute the ambient occlusion lighting. We specifically wanted to make the client simple.
</p>
<p>The abstraction process is described in our paper Molecular Surface Abstractions (project page) (IEEE page). If you find the tool useful, please cite this paper.</p>

<h3>About this server</h3>
<p>The backend server consists of two components:</p>

    C++ code to read in PDB files and generate abstractions. This program uses other programs to compute some of the data about the molecule (as described above).
    A combination of Python and PHP to manage user accounts, and coordinate jobs. The job management system was developed by Julie Mitchell and her colleagues and provides a uniform interface to a number of tools. 


<h3>About the abstraction viewer</h3>

<p>The abstracted protein surface viewer is written in javascript, using WebGL to render its 3D images. Each abstraction job produces a compressed archive, containing the following: 3D meshes for each chain, in PLY format, png files for each surface label, and an xml file describing the texture locations, electrostatic and hydropathic fields.</p>

<h3>GRAPE and future abstraction tools</h3>

<p>We believe that abstracted views of protein surfaces can be a useful tool in the study of macromolecular structure and function. To date, we have been experimenting with abstracted views in a bespoke molecular visualization testbed.</p>

<p>GRAPE provides an initial way to allow people to experience abstracted visualizations of proteins. However, simply looking at a single molecule in isolation is not necessarily the most useful way to make use of abstracted views. In the future we envision:</p>

<p>Tools that better integrate with existing workflows and other visualizations. In particular, we intend to support abstracted views within standard molecular visualization tools such as PyMol. GRAPE already provides some of the required infrastructure: the server already precomputes the important aspects of the molecular abstraction (including the geometry, textures, and ambient occlusion lighting) and packages it into a compact file. Right now, this file is only used by our simple viewer client. In the future, it could be read by a plugin to a desktop visualization tool.</p>
<p>Tools that support comparison and browsing. The biggest advantages of abstracted views seem to be when we need to make comparisons among a set of molecules. In these situations, abstractions can help prevent being overwhelmed by an overload of details. Providing tools for comparison is challenging: not only are there performance issues of displaying multiple molecules simultaneously, there are interaction challenges in trying to make the displays meaningful and usable. Our experimental testbed facilitates comparison of proteins, including tools for alignment and parallel interaction. We hope to provide these functions in either web-based, or at least deployable tools.</p>
<p>Tools that provide improved abstractions to provide even more information about molecules in these convenient views. For example, we have already developed techniques for illustrating protein flexibility and providing surface labels that can display annotations. We hope to integrate these into web-based or desktop tools that we can distribute.</p>

<p>We hope that GRAPE can give you a taste of what abstracted surface representations may be useful for, so you will be able to make use of them in future tools. Please let us know if you find GRAPE useful, would be interested in trying out future tools, or have ideas on how better abstraction tools might be able to help you in your work.</p>

<h3>About Us</h3>
<p>The Molecular Surface Abstraction Project is an effort of the UW Graphics Group in the Department of Computer Sciences at the University of Wisconsin - Madison. We develop tools for improving how we communicate and understand data by understanding perception and artistic traditions. The project is a collaboration with the Phillips Lab, who are our primary domain collaborators, and the Mitchell Lab, who help in trying to create deployable tools.
</p>
<p>The development of the original abstraction technology was supported in part by an NIH training grant NLM-5T15LM007359. The continued development of the abstraction technology is supported in part by an NSF CDI award 0941013. The development and support of this web site is through the BACTER Institute, a Department of Energy training program.
</p>
<h3>Key People</h3>

<p>Greg Cipriano - Computer Sciences Graduate Student, BACTER Pre-Doctoral Fellow
    Greg is the primary architect and implementor of the Surface Abstraction project. </p>
<p>Mike Gleicher - Professor, Department of Computer Sciences
    Mike is the leader of the UW Graphics Group and PI of the Molecular Surfaces project. He helps with the ideas and the design.</p>
<p>George Phillips, Jr - Professor, Department of Biochemistry (and Computer Sciences)
    George provides the knowledge of biochemistry and makes sure that what we do has some grounding in reality.</p>
<p>Tom Grim - Computer Sciences Undergraduate
    Tom was responsible for porting the abstraction system from Windows to Unix server platforms.</p>
<p>Gary Wesenberg - Systems Programmer, BACTER Institute
    Gary was responsible for tying the abstraction service into the BACTER website, including integrating it with the job management system in use for other tools.</p>

<p>Others involved: Joshua Oakgrove implemented the proof-of-concept in-browser surface viewer. Yoram Griguer and Aaron Bryden helped with Macintosh issues. Adrian Mayorga helped implement parts of the stand-alone abstraction software. Julie Mitchell convinced us to implement this as a web service and provided support and infrastructure for the site development.</p>

</div>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
