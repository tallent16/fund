
DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getBusesInfo`(`argOrderName` VARCHAR(15)) RETURNS varchar(100) CHARSET latin1
BEGIN
	DECLARE isAllfinished INTEGER DEFAULT 0;
	DECLARE busesInfo varchar(100) DEFAULT "";
	DECLARE rowValue varchar(15) DEFAULT "";
	 
	-- declare cursor for getting the list of guides
	DEClARE busesCursor CURSOR FOR
		SELECT	concat(ifnull(bookingBuses.busOperatorCode, "")) busString
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

CREATE DEFINER=`root`@`localhost` FUNCTION `getBusLocationInfo`(order_name varchar(15),order_bus_number varchar(15)) RETURNS varchar(100) CHARSET latin1
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

CREATE DEFINER=`root`@`localhost` FUNCTION `getGuideLanguagesInfo`(`guide_code` VARCHAR(15)) RETURNS varchar(100) CHARSET latin1
BEGIN
	DECLARE isAllfinished INTEGER DEFAULT 0;
	DECLARE guidelanguagesInfo varchar(100) DEFAULT "";
	DECLARE rowValue varchar(15) DEFAULT "";
	 
	-- declare cursor for getting the list of Languages
	DEClARE guidelanguagesCursor CURSOR FOR
		SELECT	concat(ifnull(guidesMasterLanguages.LanguageCode, "")) guidelanguageString
		FROM	guidesMasterLanguages 
		WHERE 	guideCode = guide_code;
	 
	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER
			FOR NOT FOUND SET isAllfinished = 1;
	 
	OPEN guidelanguagesCursor;
	 
	getGuideLanguagesList: LOOP
	 
		FETCH guidelanguagesCursor INTO rowValue;
		 
		IF isAllfinished = 1 THEN
			LEAVE getGuideLanguagesList;
		END IF;
		 
		-- build email list
		SET guidelanguagesInfo = CONCAT(rowValue,",",guidelanguagesInfo);
		 
	END LOOP getGuideLanguagesList;
	 
	CLOSE guidelanguagesCursor;
	
	RETURN TRIM(TRAILING ',' FROM guidelanguagesInfo);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getGuidesInfo`(argOrderName varchar(15)) RETURNS varchar(100) CHARSET latin1
BEGIN
	DECLARE isAllfinished INTEGER DEFAULT 0;
	DECLARE guidesInfo varchar(100) DEFAULT "";
	DECLARE rowValue varchar(15) DEFAULT "";
	 
	-- declare cursor for getting the list of guides
	DEClARE guidesCursor CURSOR FOR
		SELECT	concat(if((bkg.GuideCode is not null) AND (bkg.GuideCode <>''),gm.guideFirstName,bkg.GuideCode), 
				if((bkg.subTourCode is not null) AND (bkg.subTourCode <>''), "[",""), 
				ifnull(bkg.subTourCode, ""), 
				if((bkg.subTourCode is not null) AND (bkg.subTourCode <>''), "]","")) guideString
		FROM	bookingGuides bkg,guidesMaster gm 
		WHERE 	orderName = argOrderName
		AND	bkg.GuideCode=gm.guideCode;
	 
	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER
			FOR NOT FOUND SET isAllfinished = 1;
	 
	OPEN guidesCursor;
	 
	getGuidesList: LOOP
	 
		FETCH guidesCursor INTO rowValue;
		 
		IF isAllfinished = 1 THEN
			LEAVE getGuidesList;
		END IF;
		 
		-- build email list
		SET guidesInfo = CONCAT(rowValue,";",guidesInfo);
		 
	END LOOP getGuidesList;
	 
	CLOSE guidesCursor;

	RETURN guidesInfo;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getLanguagesInfo`(argOrderName varchar(15)) RETURNS varchar(100) CHARSET utf8
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

