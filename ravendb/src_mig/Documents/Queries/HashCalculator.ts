import * as md5 from "md5";
import { TypeUtil } from "../../Utility/TypeUtil";
import { JsonSerializer } from "../../Mapping/Json/Serializer";

export class HashCalculator {

    private _buffers: Buffer[] = [];

    public getHash(): string {
        return md5(Buffer.concat(this._buffers));
    }

    //TBD 4.1 public void Write(HighlightedField[] highlightedFields)

    public write(o: any) {
        if (TypeUtil.isNullOrUndefined(o)) {
            this._buffers.push(Buffer.from("null"));
            return;
        }

        if (typeof o === "number") {
            this._buffers.push(Buffer.from([o]));
        } else if (typeof o === "string") {
            this._buffers.push(Buffer.from(o));
        } else if (typeof o === "boolean") {
            this._buffers.push(Buffer.from(o ? [1] : [2]));
        } else if (Array.isArray(o)) {
            for (const item of o) {
                this.write(item);
            }
        } else if (typeof o === "object") {
            for (const key of Object.keys(o)) {
                this.write(key);
                this.write(o[key]);
            }
        } else {
            this.write(JsonSerializer.getDefaultForEntities().serialize(o));
        }
    }
}
