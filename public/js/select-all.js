function select_all()
{
	for(i=0; i<document.frm.elements.length; i++)
	{
		if(document.frm.elements[i].type == "checkbox" &&
			document.frm.elements[i].checked == 0)
		{
			document.frm.elements[i].checked = 1;
		}
		else if(document.frm.elements[i].type == "checkbox" &&
				document.frm.elements[i].checked == 1)
		{
			document.frm.elements[i].checked = 0;
		}
	}
}


function seleccionar_todo(){
		   for (i=0;i<document.f1.elements.length;i++)
		      if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].checked==0)
		         document.f1.elements[i].checked=1
		     else if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].checked==1)
		     	document.f1.elements[i].checked=0
		}