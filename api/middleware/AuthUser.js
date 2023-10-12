import User from "../models/UserModel.js";

export const verifyUser = async (req, res, next) => {

  let uuid = req.query.uuid ? req.query.uuid : req.body.uuid;
  let token = req.query.token ? req.query.token : req.body.token;

  // if (!req.body.uuid) {
  //   return res.status(204).json({ status: false, msg: "Mohon login ke akun Andaea!" });
  // }

  const user = await User.findOne({
    where: {
      uuid: uuid,
      // role: "admin",
    },
  });

  if (!user) {
    return res.status(204).json({
      status: false,
      msg: "User tidak ditemukan"
    })
  };

  if (token != user.token) {
    return res.status(206).json({
      status: false,
      msg: "Tokens don't match"
    });
  }
  // req.userId = user.id;
  // req.role = user.role;
  next();
};

export const adminOnly = async (req, res, next) => {
  let uuid = req.query.uuid ? req.query.uuid : req.body.uuid;
  let token = req.query.token ? req.query.token : req.body.token;

  const user = await User.findOne({
    where: {
      uuid: uuid,
    },
  });

  // return res.status(204).json({
  //   status: false,
  //   msg: "User tidak ditemukan"
  // });

  if (!user) {
    return res.status(204).json({
      status: false,
      msg: "User tidak ditemukan"
    });
  }

  if (token != user.token) {
    return res.status(206).json({
      status: false,
      msg: "Tokens don't match"
    });
  }

  if (user.role !== "admin") {
    return res.status(203).json({
      status: false,
      msg: "Hanya diakses oleh admin"
    });
  }

  next();
};
