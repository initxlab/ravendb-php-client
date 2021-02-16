<?php
namespace RavenDB\Client;
/**
 * Class IConstants
 * @package RavenDB\Client
 * Defining Constants on IConstants Interface to match the same goal in JAVA
 * Java Client Version:
 * https://raw.githubusercontent.com/ravendb/ravendb-jvm-client/v5.0/src/main/java/net/ravendb/client/Constants.java
 * calling path to constant in java : Constants.Documents.Indexing.Fields.DOCUMENT_ID_FIELD_NAME
 * In PHP IConstants::DOCUMENT_ID_FIELD_NAME
 */
interface IConstants
{
    /**
     * DOCUMENTS_METADATA PREFIX CONSTANTS SCOPE
    */
    public const METADATA_COLLECTION="@collection";
    public const METADATA_PROJECTION="@projection";
    public const METADATA_KEY="@metadata";
    public const METADATA_ID="@id";
    public const METADATA_CONFLICT="@conflict";
    public const METADATA_ID_PROPERTY="@Id";
    public const METADATA_FLAGS="@flags";
    public const METADATA_ATTACHMENTS="@attachments";
    public const METADATA_TIME_SERIES="@timeseries";
    public const METADATA_REVISION_COUNTERS="@counters-snapshot";
    public const METADATA_REVISION_TIME_SERIES="@timeseries-snapshot";
    public const METADATA_INDEX_SCORE="@index-score";
    public const METADATA_LAST_MODIFIED="@last-modified";
    public const METADATA_RAVEN_JAVA_TYPE="Raven-Java-Type";
    public const METADATA_CHANGE_VECTOR="@change-vector";
    public const METADATA_EXPIRES="@expires";
    public const METADATA_ALL_COLLECTION="@all_docs";
    /**
     * DOCUMENTS_INDEXING PREFIX CONSTANTS SCOPE
     */
    public const INDEXING_SIDE_BY_SIDE_INDEX_NAME_PREFIX="ReplacementOf/";
    public const INDEXING_DOCUMENT_ID_FIELD_NAME="id()";
    public const INDEXING_SOURCE_DOCUMENT_ID_FIELD_NAME="sourceDocId()";
    public const INDEXING_REDUCE_KEY_HASH_FIELD_NAME="hash(key())";
    public const INDEXING_REDUCE_KEY_KEY_VALUE_FIELD_NAME="key()";
    public const INDEXING_VALUE_FIELD_NAME="value()";
    public const INDEXING_ALL_FIELDS="__all_fields";
    public const INDEXING_SPATIAL_SHAPE_FIELD_NAME="spatial(shape)";
    public const INDEXING_SPATIAL_DEFAULT_DISTANCE_ERROR_PCT="0.025d"; // hex
    //  public const INDEXING_CUSTOM_SORT_FIELD_NAME="__customSort"; // TBD 4.1

    public const PERIODICBKP_FULL_BACKUP_EXTENSION="ravendb-full-backup";
    public const PERIODICBKP_SNAPSHOT_EXTENSION="ravendb-snapshot";
    public const PERIODICBKP_ENCRYPTED_FULL_BACKUP_EXTENSION=".ravendb-encrypted-full-backup";
    public const PERIODICBKP_ENCRYPTED_SNAPSHOT_EXTENSION=".ravendb-encrypted-snapshot";
    public const PERIODICBKP_INCREMENTAL_BACKUP_EXTENSION="ravendb-incremental-backup";
    public const PERIODICBKP_ENCRYPTED_INCREMENTAL_BACKUP_EXTENSION=".ravendb-encrypted-incremental-backup";

    public const PERIODICBKP_FOLDER_INDEXES="Indexes";
    public const PERIODICBKP_FOLDER_DOCUMENTS="Documents";
    public const PERIODICBKP_FOLDER_CONFIGURATION="Configuration";

    public const HEADERS_REQUEST_TIME="Raven-Request-Time";
    public const HEADERS_REFRESH_TOPOLOGY="Refresh-Topology";
    public const HEADERS_TOPOLOGY_ETAG="Topology-Etag";
    public const HEADERS_LAST_KNOWN_CLUSTER_TRANSACTION_INDEX="Known-Raft-Index";
    public const HEADERS_CLIENT_CONFIGURATION_ETAG="Client-Configuration-Etag";
    public const HEADERS_REFRESH_CLIENT_CONFIGURATION="Refresh-Client-Configuration";
    public const HEADERS_CLIENT_VERSION="Raven-Client-Version";
    public const HEADERS_SERVER_VERSION="Raven-Server-Version";
    public const HEADERS_ETAG="ETag";
    public const HEADERS_IF_NONE_MATCH="If-None-Match";
    public const HEADERS_TRANSFER_ENCODING="Transfer-Encoding";
    public const HEADERS_CONTENT_ENCODING="Content-Encoding";
    public const HEADERS_CONTENT_LENGTH="Content-Length";

    public const COUNTERS_ALL="@all_counters";
    public const TIMESERIES_SELECT_FIELD_NAME = "timeseries";
    public const TIMESERIES_QUERY_FUNCTION = "__timeSeriesQueryFunction";
    public const TIMESERIES_ALL = "@all_timeseries";

}