select * 
from Profesiones a,Profesional b
where idProfesiones not in(select Profesiones_idProfesiones from Postulacion)
and BINARY a.Profesional_idProfesional = BINARY b.idProfesional;
