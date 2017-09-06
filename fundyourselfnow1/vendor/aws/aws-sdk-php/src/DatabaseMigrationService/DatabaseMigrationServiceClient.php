<?php
namespace Aws\DatabaseMigrationService;

use Aws\AwsClient;

/**
 * This client is used to interact with the **AWS Database Migration Service** service.
 * @method \Aws\Result addTagsToResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise addTagsToResourceAsync(array $args = [])
 * @method \Aws\Result createEndpoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createEndpointAsync(array $args = [])
 * @method \Aws\Result createReplicationInstance(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createReplicationInstanceAsync(array $args = [])
 * @method \Aws\Result createReplicationSubnetGroup(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createReplicationSubnetGroupAsync(array $args = [])
 * @method \Aws\Result createReplicationTask(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createReplicationTaskAsync(array $args = [])
 * @method \Aws\Result deleteCertificate(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteCertificateAsync(array $args = [])
 * @method \Aws\Result deleteEndpoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteEndpointAsync(array $args = [])
 * @method \Aws\Result deleteReplicationInstance(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteReplicationInstanceAsync(array $args = [])
 * @method \Aws\Result deleteReplicationSubnetGroup(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteReplicationSubnetGroupAsync(array $args = [])
 * @method \Aws\Result deleteReplicationTask(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteReplicationTaskAsync(array $args = [])
 * @method \Aws\Result describeAccountAttributes(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeAccountAttributesAsync(array $args = [])
 * @method \Aws\Result describeCertificates(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeCertificatesAsync(array $args = [])
 * @method \Aws\Result describeConnections(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeConnectionsAsync(array $args = [])
 * @method \Aws\Result describeEndpointTypes(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeEndpointTypesAsync(array $args = [])
 * @method \Aws\Result describeEndpoints(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeEndpointsAsync(array $args = [])
 * @method \Aws\Result describeOrderableReplicationInstances(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeOrderableReplicationInstancesAsync(array $args = [])
 * @method \Aws\Result describeRefreshSchemasStatus(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeRefreshSchemasStatusAsync(array $args = [])
 * @method \Aws\Result describeReplicationInstances(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationInstancesAsync(array $args = [])
 * @method \Aws\Result describeReplicationSubnetGroups(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationSubnetGroupsAsync(array $args = [])
 * @method \Aws\Result describeReplicationTasks(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeReplicationTasksAsync(array $args = [])
 * @method \Aws\Result describeSchemas(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeSchemasAsync(array $args = [])
 * @method \Aws\Result describeTableStatistics(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeTableStatisticsAsync(array $args = [])
 * @method \Aws\Result importCertificate(array $args = [])
 * @method \GuzzleHttp\Promise\Promise importCertificateAsync(array $args = [])
 * @method \Aws\Result listTagsForResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listTagsForResourceAsync(array $args = [])
 * @method \Aws\Result modifyEndpoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyEndpointAsync(array $args = [])
 * @method \Aws\Result modifyReplicationInstance(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyReplicationInstanceAsync(array $args = [])
 * @method \Aws\Result modifyReplicationSubnetGroup(array $args = [])
 * @method \GuzzleHttp\Promise\Promise modifyReplicationSubnetGroupAsync(array $args = [])
 * @method \Aws\Result refreshSchemas(array $args = [])
 * @method \GuzzleHttp\Promise\Promise refreshSchemasAsync(array $args = [])
 * @method \Aws\Result removeTagsFromResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise removeTagsFromResourceAsync(array $args = [])
 * @method \Aws\Result startReplicationTask(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startReplicationTaskAsync(array $args = [])
 * @method \Aws\Result stopReplicationTask(array $args = [])
 * @method \GuzzleHttp\Promise\Promise stopReplicationTaskAsync(array $args = [])
 * @method \Aws\Result testConnection(array $args = [])
 * @method \GuzzleHttp\Promise\Promise testConnectionAsync(array $args = [])
 */
class DatabaseMigrationServiceClient extends AwsClient {}
