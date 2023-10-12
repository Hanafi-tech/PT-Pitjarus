import { createPool } from "mysql";

const pool = createPool({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'dev_pitjarus',
    connectionLimit: 10
})

export default pool;
