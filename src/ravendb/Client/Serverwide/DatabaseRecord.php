<?php

namespace RavenDB\Client\Serverwide;

class DatabaseRecord
{
    private $databaseName;
    private bool $disabled;
    private bool $encrypted;
    private float $etagForBackup;

    public function dataBaseRecord(?string $databaseName)
    {
        $this->databaseName = $databaseName;
    }

    public function setDatabaseName(string $databaseName)
    {
        $this->databaseName = $databaseName;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function setDisabled(bool $disabled): void
    {
        $this->disabled = $disabled;
    }


    public function isEncrypted(): bool
    {
        return $this->encrypted;
    }


    public function setEncrypted(bool $encrypted): void
    {
        $this->encrypted = $encrypted;
    }


    public function getEtagForBackup(): float
    {
        return $this->etagForBackup;
    }


    public function setEtagForBackup(float $etagForBackup): void
    {
        $this->etagForBackup = $etagForBackup;
    }
}
/*
 *
public class DatabaseRecord {
    private String databaseName;
    private boolean disabled;
    private boolean encrypted;
    private long etagForBackup;
    private Map<String, DeletionInProgressStatus> deletionInProgress;
    private DatabaseStateStatus databaseStatus;
    private DatabaseTopology topology;
    private ConflictSolver conflictSolverConfig;
    private DocumentsCompressionConfiguration documentsCompression;
    private Map<String, SorterDefinition> sorters = new HashMap<>();
    private Map<String, IndexDefinition> indexes;
    private Map<String, List<IndexHistoryEntry>> indexesHistory;
    private Map<String, AutoIndexDefinition> autoIndexes;
    private Map<String, String> settings = new HashMap<>();
    private RevisionsConfiguration revisions;
    private TimeSeriesConfiguration timeSeries;
    private RevisionsCollectionConfiguration revisionsForConflicts;
    private ExpirationConfiguration expiration;
    private RefreshConfiguration refresh;
    private List<PeriodicBackupConfiguration> periodicBackups = new ArrayList<>();
    private List<ExternalReplication> externalReplications = new ArrayList<>();
    private List<PullReplicationAsSink> sinkPullReplications = new ArrayList<>();
    private List<PullReplicationDefinition> hubPullReplications = new ArrayList<>();
    private Map<String, RavenConnectionString> ravenConnectionStrings = new HashMap<>();
    private Map<String, SqlConnectionString> sqlConnectionStrings = new HashMap<>();
    private List<RavenEtlConfiguration> ravenEtls = new ArrayList<>();
    private List<SqlEtlConfiguration> sqlEtls = new ArrayList<>();
    private ClientConfiguration client;
    private StudioConfiguration studio;
    private long truncatedClusterTransactionCommandsCount;
    private Set<String> unusedDatabaseIds = new HashSet<>();

    public DatabaseRecord() {
    }

    public DatabaseRecord(String databaseName) {
        this.databaseName = databaseName;
    }

    public String getDatabaseName() {
        return databaseName;
    }

    public void setDatabaseName(String databaseName) {
        this.databaseName = databaseName;
    }

    public boolean isDisabled() {
        return disabled;
    }

    public void setDisabled(boolean disabled) {
        this.disabled = disabled;
    }

    public Map<String, String> getSettings() {
        return settings;
    }

    public void setSettings(Map<String, String> settings) {
        this.settings = settings;
    }

    public ConflictSolver getConflictSolverConfig() {
        return conflictSolverConfig;
    }

    public void setConflictSolverConfig(ConflictSolver conflictSolverConfig) {
        this.conflictSolverConfig = conflictSolverConfig;
    }

    public DocumentsCompressionConfiguration getDocumentsCompression() {
        return documentsCompression;
    }

    public void setDocumentsCompression(DocumentsCompressionConfiguration documentsCompression) {
        this.documentsCompression = documentsCompression;
    }

    public boolean isEncrypted() {
        return encrypted;
    }

    public void setEncrypted(boolean encrypted) {
        this.encrypted = encrypted;
    }

    public long getEtagForBackup() {
        return etagForBackup;
    }

    public void setEtagForBackup(long etagForBackup) {
        this.etagForBackup = etagForBackup;
    }

    public Map<String, DeletionInProgressStatus> getDeletionInProgress() {
        return deletionInProgress;
    }

    public void setDeletionInProgress(Map<String, DeletionInProgressStatus> deletionInProgress) {
        this.deletionInProgress = deletionInProgress;
    }

    public DatabaseTopology getTopology() {
        return topology;
    }

    public void setTopology(DatabaseTopology topology) {
        this.topology = topology;
    }

    public Map<String, SorterDefinition> getSorters() {
        return sorters;
    }

    public void setSorters(Map<String, SorterDefinition> sorters) {
        this.sorters = sorters;
    }

    public Map<String, IndexDefinition> getIndexes() {
        return indexes;
    }

    public void setIndexes(Map<String, IndexDefinition> indexes) {
        this.indexes = indexes;
    }

    public Map<String, AutoIndexDefinition> getAutoIndexes() {
        return autoIndexes;
    }

    public void setAutoIndexes(Map<String, AutoIndexDefinition> autoIndexes) {
        this.autoIndexes = autoIndexes;
    }

    public RevisionsConfiguration getRevisions() {
        return revisions;
    }

    public void setRevisions(RevisionsConfiguration revisions) {
        this.revisions = revisions;
    }

    public TimeSeriesConfiguration getTimeSeries() {
        return timeSeries;
    }

    public void setTimeSeries(TimeSeriesConfiguration timeSeries) {
        this.timeSeries = timeSeries;
    }

    public ExpirationConfiguration getExpiration() {
        return expiration;
    }

    public void setExpiration(ExpirationConfiguration expiration) {
        this.expiration = expiration;
    }

    public List<PeriodicBackupConfiguration> getPeriodicBackups() {
        return periodicBackups;
    }

    public void setPeriodicBackups(List<PeriodicBackupConfiguration> periodicBackups) {
        this.periodicBackups = periodicBackups;
    }

    public List<ExternalReplication> getExternalReplications() {
        return externalReplications;
    }

    public void setExternalReplications(List<ExternalReplication> externalReplications) {
        this.externalReplications = externalReplications;
    }

    public List<PullReplicationAsSink> getSinkPullReplications() {
        return sinkPullReplications;
    }

    public void setSinkPullReplications(List<PullReplicationAsSink> sinkPullReplications) {
        this.sinkPullReplications = sinkPullReplications;
    }

    public List<PullReplicationDefinition> getHubPullReplications() {
        return hubPullReplications;
    }

    public void setHubPullReplications(List<PullReplicationDefinition> hubPullReplications) {
        this.hubPullReplications = hubPullReplications;
    }

    public Map<String, RavenConnectionString> getRavenConnectionStrings() {
        return ravenConnectionStrings;
    }

    public void setRavenConnectionStrings(Map<String, RavenConnectionString> ravenConnectionStrings) {
        this.ravenConnectionStrings = ravenConnectionStrings;
    }

    public Map<String, SqlConnectionString> getSqlConnectionStrings() {
        return sqlConnectionStrings;
    }

    public void setSqlConnectionStrings(Map<String, SqlConnectionString> sqlConnectionStrings) {
        this.sqlConnectionStrings = sqlConnectionStrings;
    }

    public List<RavenEtlConfiguration> getRavenEtls() {
        return ravenEtls;
    }

    public void setRavenEtls(List<RavenEtlConfiguration> ravenEtls) {
        this.ravenEtls = ravenEtls;
    }

    public List<SqlEtlConfiguration> getSqlEtls() {
        return sqlEtls;
    }

    public void setSqlEtls(List<SqlEtlConfiguration> sqlEtls) {
        this.sqlEtls = sqlEtls;
    }

    public ClientConfiguration getClient() {
        return client;
    }

    public void setClient(ClientConfiguration client) {
        this.client = client;
    }

    public StudioConfiguration getStudio() {
        return studio;
    }

    public void setStudio(StudioConfiguration studio) {
        this.studio = studio;
    }

    public long getTruncatedClusterTransactionCommandsCount() {
        return truncatedClusterTransactionCommandsCount;
    }

    public void setTruncatedClusterTransactionCommandsCount(long truncatedClusterTransactionCommandsCount) {
        this.truncatedClusterTransactionCommandsCount = truncatedClusterTransactionCommandsCount;
    }

    public DatabaseStateStatus getDatabaseStatus() {
        return databaseStatus;
    }

    public void setDatabaseStatus(DatabaseStateStatus databaseStatus) {
        this.databaseStatus = databaseStatus;
    }

    public Map<String, List<IndexHistoryEntry>> getIndexesHistory() {
        return indexesHistory;
    }

    public void setIndexesHistory(Map<String, List<IndexHistoryEntry>> indexesHistory) {
        this.indexesHistory = indexesHistory;
    }

    public RevisionsCollectionConfiguration getRevisionsForConflicts() {
        return revisionsForConflicts;
    }

    public void setRevisionsForConflicts(RevisionsCollectionConfiguration revisionsForConflicts) {
        this.revisionsForConflicts = revisionsForConflicts;
    }

    public RefreshConfiguration getRefresh() {
        return refresh;
    }

    public void setRefresh(RefreshConfiguration refresh) {
        this.refresh = refresh;
    }

    public Set<String> getUnusedDatabaseIds() {
        return unusedDatabaseIds;
    }

    public void setUnusedDatabaseIds(Set<String> unusedDatabaseIds) {
        this.unusedDatabaseIds = unusedDatabaseIds;
    }

    public static class IndexHistoryEntry {
        private IndexDefinition definition;
        private String source;
        private Date createdAt;

        public IndexDefinition getDefinition() {
            return definition;
        }

        public void setDefinition(IndexDefinition definition) {
            this.definition = definition;
        }

        public String getSource() {
            return source;
        }

        public void setSource(String source) {
            this.source = source;
        }

        public Date getCreatedAt() {
            return createdAt;
        }

        public void setCreatedAt(Date createdAt) {
            this.createdAt = createdAt;
        }
    }

    @UseSharpEnum
    public enum DatabaseStateStatus {
        NORMAL,
        RESTORE_IN_PROGRESS
    }
}

 * */