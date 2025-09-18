import { motion } from 'framer-motion';
import { Product } from '@/types/product';

interface ProductCardProps {
  product: Product;
}

export default function ProductCard({ product }: ProductCardProps) {
  const formatPrice = (price: number, currency: string) => {
    return new Intl.NumberFormat('th-TH', {
      style: 'currency',
      currency: currency,
    }).format(price);
  };

  const renderStars = (rating: number) => {
    return Array.from({ length: 5 }, (_, i) => (
      <span
        key={i}
        className={`text-sm ${
          i < Math.floor(rating) ? 'text-yellow-400' : 'text-gray-300'
        }`}
      >
        ★
      </span>
    ));
  };

  return (
    <motion.div
      whileHover={{ y: -8 }}
      transition={{ duration: 0.3 }}
      className="apple-card group cursor-pointer"
    >
      {/* Product Image */}
      <div className="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl mb-6 overflow-hidden relative">
        <div className="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-500/10 flex items-center justify-center">
          <div className="text-6xl text-gray-400">📷</div>
        </div>
        {product.availability === 'in-stock' && (
          <div className="absolute top-3 right-3 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
            In Stock
          </div>
        )}
        {product.availability === 'out-of-stock' && (
          <div className="absolute top-3 right-3 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
            Out of Stock
          </div>
        )}
        {product.availability === 'pre-order' && (
          <div className="absolute top-3 right-3 bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
            Pre-Order
          </div>
        )}
      </div>

      {/* Product Info */}
      <div>
        <div className="flex items-center justify-between mb-2">
          <span className="text-sm text-blue-600 font-medium capitalize">
            {product.category.replace('-', ' ')}
          </span>
          <div className="flex items-center space-x-1">
            {renderStars(product.rating)}
            <span className="text-sm text-gray-500 ml-1">({product.reviewCount})</span>
          </div>
        </div>

        <h3 className="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
          {product.name}
        </h3>

        <p className="text-gray-600 mb-4 line-clamp-2">
          {product.description}
        </p>

        {/* Key Features */}
        <div className="mb-4">
          <div className="flex flex-wrap gap-2">
            {product.features.slice(0, 2).map((feature, index) => (
              <span
                key={index}
                className="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full"
              >
                {feature}
              </span>
            ))}
            {product.features.length > 2 && (
              <span className="text-xs text-gray-500">
                +{product.features.length - 2} more
              </span>
            )}
          </div>
        </div>

        {/* Key Specifications */}
        <div className="mb-6 space-y-1">
          {Object.entries(product.specifications).slice(0, 2).map(([key, value]) => (
            <div key={key} className="flex justify-between text-sm">
              <span className="text-gray-500">{key}:</span>
              <span className="text-gray-700 font-medium">{value}</span>
            </div>
          ))}
        </div>

        {/* Price and CTA */}
        <div className="flex items-center justify-between">
          <div>
            <div className="text-2xl font-bold text-gray-900">
              {formatPrice(product.price, product.currency)}
            </div>
            <div className="text-sm text-gray-500">Including VAT</div>
          </div>
          
          <div className="flex flex-col space-y-2">
            <button className="apple-button text-sm px-4 py-2">
              View Details
            </button>
            {product.availability === 'in-stock' && (
              <button className="apple-button-secondary text-sm px-4 py-2">
                Add to Cart
              </button>
            )}
            {product.availability === 'pre-order' && (
              <button className="apple-button-secondary text-sm px-4 py-2">
                Pre-Order
              </button>
            )}
            {product.availability === 'out-of-stock' && (
              <button className="bg-gray-300 text-gray-500 text-sm px-4 py-2 rounded-lg cursor-not-allowed" disabled>
                Out of Stock
              </button>
            )}
          </div>
        </div>
      </div>
    </motion.div>
  );
}