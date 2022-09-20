select 
a.userEstado, a.username,b.ProfesionalMail,b.ProfesionalMail2,
b.ProfesionalNombres,b.ProfesionalApellidos,b.ProfesionalGenero,
b.ProfesionalTlfmovil,b.ProfesionalTlfFijo,
e.NacionalidadNombre,f.TipoDocIDNombre,
d.* 
from 
user a, Profesional b, 
Profesiones c, Postulacion d ,
Nacionalidad e,TipoDocID f
where 
BINARY a.username = BINARY b.idProfesional and
BINARY c.Profesional_idProfesional = BINARY a.username and 
BINARY c.idProfesiones = BINARY d.Profesiones_idProfesiones and
b.Nacionalidad_idNacionalidad = e.idNacionalidad and
b.TipoDocID_idTipoDocID = f.idTipoDocID
order by 
d.PostulacionAprobado, b.Nacionalidad_idNacionalidad,a.username;
