DELIMITER $$
DROP FUNCTION IF EXISTS getBusesInfo $$
 
CREATE FUNCTION getBusesInfo (argOrderName varchar(15)) RETURNS varchar(100)
BEGIN
	DECLARE isAllfinished INTEGER DEFAULT 0;
	DECLARE busesInfo varchar(100) DEFAULT "";
	DECLARE rowValue varchar(15) DEFAULT "";
	 
	-- declare cursor for getting the list of guides
	DEClARE busesCursor CURSOR FOR
		SELECT	concat(ifnull(bookingBuses.busOperatorCode, ""), "[", 
				ifnull(bookingBuses.orderBusStartLocation, ""), "] (",
				ifnull(bookingBuses.busType, ""), ")") busString
		FROM	bookingBuses 
		WHERE 	orderName = argOrderName;
	 
	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER
			FOR NOT FOUND SET isAllfinished = 1;
	 
	OPEN busesCursor;
	 
	getBusesList: LOOP
	 
		FETCH busesCursor INTO rowValue;
		 
		IF isAllfinished = 1 THEN
			LEAVE getBusesList;
		END IF;
		 
		-- build email list
		SET busesInfo = CONCAT(rowValue,";",busesInfo);
		 
	END LOOP getBusesList;
	 
	CLOSE busesCursor;

	RETURN busesInfo;
END$$
 
DELIMITER ;
