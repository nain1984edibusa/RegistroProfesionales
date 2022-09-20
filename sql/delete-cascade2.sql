SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `regprof`.`AccionEnPostulacion` 
DROP FOREIGN KEY `fk_AccionEnPostulacion_Postulacion1`;

ALTER TABLE `regprof`.`FAcademica` 
DROP FOREIGN KEY `fk_FAcademica_Profesional1`;

ALTER TABLE `regprof`.`FacadEnPost` 
DROP FOREIGN KEY `fk_FacadEnPost_FAcademica1`;

ALTER TABLE `regprof`.`InformeTecnico` 
DROP FOREIGN KEY `fk_InformeTecnico_Postulacion1`;

ALTER TABLE `regprof`.`Postulacion` 
DROP FOREIGN KEY `fk_Postulacion_Profesiones1`;

ALTER TABLE `regprof`.`Profesiones` 
DROP FOREIGN KEY `fk_Profesiones_Profesional1`;

ALTER TABLE `regprof`.`RegistroP` 
DROP FOREIGN KEY `fk_RegistroP_Profesional1`;

ALTER TABLE `regprof`.`SolicitudRespuesta` 
DROP FOREIGN KEY `fk_SolicitudRespuesta_Postulacion1`;

ALTER TABLE `regprof`.`AccionEnPostulacion` 
ADD CONSTRAINT `fk_AccionEnPostulacion_Postulacion1`
  FOREIGN KEY (`Postulacion_idPostulacion`)
  REFERENCES `regprof`.`Postulacion` (`idPostulacion`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;

ALTER TABLE `regprof`.`FAcademica` 
ADD CONSTRAINT `fk_FAcademica_Profesional1`
  FOREIGN KEY (`Profesional_idProfesional`)
  REFERENCES `regprof`.`Profesional` (`idProfesional`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;

ALTER TABLE `regprof`.`FacadEnPost` 
ADD CONSTRAINT `fk_FacadEnPost_FAcademica1`
  FOREIGN KEY (`FAcademica_idFAcademica`)
  REFERENCES `regprof`.`FAcademica` (`idFAcademica`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;

ALTER TABLE `regprof`.`InformeTecnico` 
ADD CONSTRAINT `fk_InformeTecnico_Postulacion1`
  FOREIGN KEY (`Postulacion_idPostulacion`)
  REFERENCES `regprof`.`Postulacion` (`idPostulacion`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;

ALTER TABLE `regprof`.`Postulacion` 
ADD CONSTRAINT `fk_Postulacion_Profesiones1`
  FOREIGN KEY (`Profesiones_idProfesiones`)
  REFERENCES `regprof`.`Profesiones` (`idProfesiones`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;

ALTER TABLE `regprof`.`Profesiones` 
ADD CONSTRAINT `fk_Profesiones_Profesional1`
  FOREIGN KEY (`Profesional_idProfesional`)
  REFERENCES `regprof`.`Profesional` (`idProfesional`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;

ALTER TABLE `regprof`.`RegistroP` 
ADD CONSTRAINT `fk_RegistroP_Profesional1`
  FOREIGN KEY (`Profesional_idProfesional`)
  REFERENCES `regprof`.`Profesional` (`idProfesional`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;

ALTER TABLE `regprof`.`SolicitudRespuesta` 
ADD CONSTRAINT `fk_SolicitudRespuesta_Postulacion1`
  FOREIGN KEY (`Postulacion_idPostulacion`)
  REFERENCES `regprof`.`Postulacion` (`idPostulacion`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
