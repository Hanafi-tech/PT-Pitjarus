import db from "../config/db.js";

export const fetchData = async (query) => {
    try {
        const data = await new Promise((resolve, reject) => {
            db.query(query, (err, result, fields) => {
                if (err) {
                    reject(err);
                } else {
                    resolve(result);
                }
            });
        });

        return data;
    } catch (err) {
        return null;
    }
}