/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  swcMinify: true,
  images: {
    domains: ['www.nilfisk.co.th'],
  },
  experimental: {
    appDir: false,
  },
}

module.exports = nextConfig