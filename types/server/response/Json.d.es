package server.response;
import server.kernel.Response;
declare class Json<T> extends Response<T>{
    constructor(cookie:server.kernel.Cookie, data?:string, code?:number)
}