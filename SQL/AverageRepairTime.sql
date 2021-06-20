SELECT 
repairPlaceId as PlaceId,
place as PlaceName,
CAST(AVG(HOUR(TIMEDIFF(repairCompleteDate,createdDate))) AS DECIMAL(10,2)) AS AverageRepairTime 
FROM `services` 
INNER JOIN repairplace ON services.repairPlaceId=repairplace.id 
GROUP BY repairPlaceId
