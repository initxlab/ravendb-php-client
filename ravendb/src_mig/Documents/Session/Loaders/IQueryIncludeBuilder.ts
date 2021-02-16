import { IGenericIncludeBuilder } from "./IGenericIncludeBuilder";

export interface IQueryIncludeBuilder extends IGenericIncludeBuilder<IQueryIncludeBuilder> {

    includeCounter(name: string): IQueryIncludeBuilder;
    includeCounter(path: string, name: string): IQueryIncludeBuilder;

    includeCounters(names: string[]): IQueryIncludeBuilder;
    includeCounters(path: string, names: string[]): IQueryIncludeBuilder;

    includeAllCounters(): IQueryIncludeBuilder;
    includeAllCounters(path: string): IQueryIncludeBuilder;

    includeTimeSeries(name: string): IQueryIncludeBuilder;
    includeTimeSeries(name: string, from: Date, to: Date): IQueryIncludeBuilder;
    includeTimeSeries(path: string, name: string): IQueryIncludeBuilder;
    includeTimeSeries(path: string, name: string, from: Date, to: Date): IQueryIncludeBuilder;
}
