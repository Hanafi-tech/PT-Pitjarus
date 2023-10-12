import { fetchData } from "../models/DbModels.js";

export const getArea = async (req, res) => {
    try {
        let query = `SELECT * FROM store_area`

        const data = await fetchData(query);

        if (data !== null) {
            res.status(200).json({ success: true, data: data });
        } else {
            res.status(500).json({ success: false, error: "Gagal mengambil data." });
        }

    } catch (error) {
        res.status(500).json({ msg: error.message });
    }
};

export const getChart = async (req, res) => {
    try {
        const { area, from, to } = req.query;

        let query = `SELECT
        store_area.area_name,
        (SUM(report_product.compliance) / COUNT(*) * 100) AS COUNT
        FROM report_product
        INNER JOIN store ON store.store_id = report_product.store_id
        INNER JOIN store_area ON store_area.area_id = store.area_id WHERE report_product.store_id IS NOT NULL`

        // console.log(area)
        if (area) {
            query += ` AND store_area.area_id IN (${area})`
        }

        if (from) {
            query += ` AND report_product.tanggal >= '${from}'`
        }

        if (to) {
            query += ` AND report_product.tanggal <= '${to}'`
        }

        query += ` GROUP BY store_area.area_name`

        const data = await fetchData(query);

        if (data !== null) {
            res.status(200).json({ success: true, data: data });
        } else {
            res.status(500).json({ success: false, error: "Gagal mengambil data." });
        }

    } catch (error) {
        res.status(500).json({ msg: error.message });
    }
};

export const getList = async (req, res) => {
    try {
        const { area, from, to } = req.query;

        let query = `SELECT brand_name, area_name, SUM(percent)/COUNT(*) AS percent FROM v_report WHERE brand_name IS NOT NULL`
        let query2 = `SELECT * FROM product_brand`

        console.log(area)
        if (area) {
            query += ` AND area_id IN (${area})`
        }

        if (from) {
            query += ` AND tanggal >= '${from}'`
        }

        if (to) {
            query += ` AND tanggal <= '${to}'`
        }

        query += ` GROUP BY brand_name, area_name`

        const data = await fetchData(query);
        const brand = await fetchData(query2);

        if (data !== null || brand !== null) {
            res.status(200).json({ success: true, list: data, brand: brand });
        } else {
            res.status(500).json({ success: false, error: "Gagal mengambil data." });
        }

    } catch (error) {
        res.status(500).json({ msg: error.message });
    }
};
