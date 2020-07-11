import axios from 'axios'

class ApiService {
  constructor ({ version = null, prefix = 'api', segment, options }) {
    let baseDomain = process.env.VUE_APP_API_URL
    let baseURL = version ? `${baseDomain}/${prefix}/${version}` : `${baseDomain}/${prefix}`

    let opt = {
      baseURL: `${baseURL}/${segment}`,
      withCredentials: false,
      ...options
    }

    let axiosInstance = axios.create(opt)

    axiosInstance.interceptors.request.use(
      (config) => {
        config.headers['Accept'] = 'application/json'
        config.headers['Content-Type'] = 'application/json'
        return config
      }, (error) => {
        return Promise.reject(error)
      }
    )

    this.client = axiosInstance
  }
}

export default ApiService
