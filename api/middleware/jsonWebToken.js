import jwt from "jsonwebtoken";
import { config } from "dotenv";
import mongoose from "mongoose";
import path from "path";
import _ from "lodash";

/* istanbul ignore next */
config({
  path:
    process.env.NODE_ENV === undefined || process.env.NODE_ENV === "development"
      ? path.resolve(".env.development")
      : path.resolve(".env.production"),
});

export default {
  generateToken: (params = {}) =>
    jwt.sign(params, process.env.JWT_SECRET, {
      expiresIn: process.env.JWT_EXPIRES_IN,
      algorithm: "HS256",
    }),

  generateRefreshToken: (params = {}) =>
    jwt.sign(params, process.env.JWT_REFRESH_SECRET, {
      expiresIn: process.env.JWT_REFRESH_EXPIRES_IN,
      algorithm: "HS256",
    }),

  isAuthenticated: (req, res, next) => {
    // get header X-No-Authorization to skip authentication
    const noAuth = req.headers["x-no-authorization"];

    if (noAuth === "1" || noAuth === 1) {
      next();
    } else if (
      req.headers.authorization &&
      req.headers.authorization.split(" ")[0] === "Bearer"
    ) {
      // get the token from the header
      const token = req.headers.authorization.split(" ")[1];

      if (token) {
        // verify the token
        jwt.verify(token, process.env.JWT_SECRET, async (err, decoded) => {
          if (err) {
            return res.status(401).json({
              status: false,
              message: "Unauthorized access tokenb",
            });
          }

          req.user = decoded.data;

          // convert id to mongoose object id
          // req.user.id = new mongoose.Types.ObjectId(req.user.id);
          // req.session.userId = req.user.id;

          // trim body
          req.body = _.mapValues(req.body, (value) => {
            if (typeof value === "string") {
              return value.trim();
            }

            return value;
          });

          // continue to the next middleware
          next();
        });
      } else {
        res.status(401).json({
          status: false,
          message: "Token malformed",
        });
      }
    } else {
      res.status(401).json({
        status: false,
        message: "Unauthorized access tokene",
      });
    }
  },

  verify(token) {
    return new Promise((resolve, reject) => {
      jwt.verify(token, process.env.JWT_SECRET, (err, decoded) => {
        if (err) {
          reject(err);
        } else {
          resolve(decoded);
        }
      });
    });
  },
};
