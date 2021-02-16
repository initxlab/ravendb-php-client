import * as stream from "readable-stream";
import { RavenCommandResponsePipeline } from "../../../Http/RavenCommandResponsePipeline";
import { pick } from "stream-json/filters/Pick";
import { streamArray } from "stream-json/streamers/StreamArray";
import { stringer } from "stream-json/Stringer";
import { DocumentConventions } from "../../../Documents/Conventions/DocumentConventions";
import { TransformKeysJsonStream } from "./TransformKeysJsonStream";
import { getTransformJsonKeysProfile } from "./TransformJsonKeysProfiles";

export function getDocumentResultsAsObjects(
    conventions: DocumentConventions): RavenCommandResponsePipeline<object[]> {

    return RavenCommandResponsePipeline.create<object[]>()
        .parseJsonAsync([
            new TransformKeysJsonStream(getTransformJsonKeysProfile("DocumentLoad", conventions)),
            pick({ filter: "results" }),
            streamArray()
        ]);
}

export function getDocumentResultsPipeline(
    conventions: DocumentConventions): RavenCommandResponsePipeline<object[]> {
    return RavenCommandResponsePipeline.create<object[]>()
        .parseJsonAsync([
            new TransformKeysJsonStream(getTransformJsonKeysProfile("DocumentLoad", conventions)),
            stringer({ useValues: true })
        ]);
}

export async function streamResultsIntoStream(
    bodyStream: stream.Stream,
    conventions: DocumentConventions,
    writable: stream.Writable): Promise<void> {

    return new Promise<void>((resolve, reject) => {
        getDocumentResultsPipeline(conventions)
            .stream(bodyStream, writable, (err) => {
                err ? reject(err) : resolve();
            });
    });
}
