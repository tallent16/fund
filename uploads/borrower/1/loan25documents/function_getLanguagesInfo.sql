DELIMITER $$
DROP FUNCTION IF EXISTS getLanguagesInfo $$
 
CREATE FUNCTION getLanguagesInfo (argOrderName varchar(15)) RETURNS varchar(100)
BEGIN
	DECLARE isAllfinished INTEGER DEFAULT 0;
	DECLARE languagesInfo varchar(100) DEFAULT "";
	DECLARE rowValue varchar(15) DEFAULT "";
	 
	-- declare cursor for getting the list of Languages
	DEClARE languagesCursor CURSOR FOR
		SELECT	concat(ifnull(bookingLanguages.languageCode, "")) languageString
		FROM	bookingLanguages 
		WHERE 	orderName = argOrderName;
	 
	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER
			FOR NOT FOUND SET isAllfinished = 1;
	 
	OPEN languagesCursor;
	 
	getLanguagesList: LOOP
	 
		FETCH languagesCursor INTO rowValue;
		 
		IF isAllfinished = 1 THEN
			LEAVE getLanguagesList;
		END IF;
		 
		-- build email list
		SET languagesInfo = CONCAT(rowValue,",",languagesInfo);
		 
	END LOOP getLanguagesList;
	 
	CLOSE languagesCursor;

	RETURN languagesInfo;
END$$
 
DELIMITER ;
