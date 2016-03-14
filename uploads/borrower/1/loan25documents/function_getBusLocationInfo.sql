DELIMITER $$
DROP FUNCTION IF EXISTS getBusLocationInfo $$
 
CREATE FUNCTION getBusLocationInfo (order_name varchar(15),order_bus_number varchar(15)) RETURNS varchar(100)
BEGIN
	DECLARE isAllfinished INTEGER DEFAULT 0;
	DECLARE busLocationInfo varchar(100) DEFAULT "";
	DECLARE rowValue varchar(15) DEFAULT "";
	 
	-- declare cursor for getting the list of Languages
	DEClARE buslocationCursor CURSOR FOR
		SELECT	concat(ifnull(bookingBusLocations.orderBusLocationParkingInfo, "")) buslocationString
		FROM	bookingBusLocations 
		WHERE 	orderName = order_name 
		AND	orderBusNumber = order_bus_number;
	 
	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER
			FOR NOT FOUND SET isAllfinished = 1;
	 
	OPEN buslocationCursor;
	 
	getBusLocationsList: LOOP
	 
		FETCH buslocationCursor INTO rowValue;
		 
		IF isAllfinished = 1 THEN
			LEAVE getBusLocationsList;
		END IF;
		 
		-- build email list
		SET busLocationInfo = CONCAT(rowValue,",",busLocationInfo);
		 
	END LOOP getBusLocationsList;
	 
	CLOSE buslocationCursor;

	RETURN TRIM(BOTH ',' FROM busLocationInfo);
END$$
 
DELIMITER ;
